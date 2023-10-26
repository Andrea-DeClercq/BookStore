<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Rent;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/books', name: 'app_book_')]
class BookController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {
        
    }

    #[Route('/browse', name: 'browse')]
    public function browseBooks(): Response
    {
        $bookList = $this->em->getRepository(Book::class)->findAll();

        return $this->render('book/browse.html.twig', [
            'bookList' => $bookList,
        ]);
    }

    #[Route('/{id}', name: ('info'))]
    public function getBooksInfo(int $id){
        # Affiche les informations d'un bouquin
        $book = $this->em->getRepository(Book::class)->findOneBy(['id' => $id]);
        return $this->render('book/book_info.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/{id}/rent', name: 'rent')]
    public function rentBook(int $id){
        /** @var User $user */
        $user = $this->getUser();
        if(!$user){
            return $this->redirectToRoute('app_login');
        }
        $book = $this->em->getRepository(Book::class)->findOneBy(['id' => $id]);
        $rent = new Rent();
        $this->em->persist($rent);
        $book->addRent($rent);
        $user->addRent($rent);
        $this->em->flush();
        return $this->redirectToRoute('app_book_info', ['id' => $id]);

    }

    #[Route('/{id}/restitute', name: 'restitute')]
    public function returnBook(int $id){
        /** @var User $user */
        $user = $this->getUser();
        if(!$user){
            return $this->redirectToRoute('app_login');
        }
        $book = $this->em->getRepository(Book::class)->findOneBy(['id' => $id]);
        $rent = $this->em->getRepository(Rent::class)->findOneBy(['user' => $user, 'book' => $book]);
        $book->getRents()->clear();
        $user->getRents()->clear();
        $this->em->remove($rent);
        $this->em->flush();
        return $this->redirectToRoute('app_book_info', ['id' => $id]);

    }

    public function myBooks(){
        # Retourne la liste des emprunts de l'utilisateur en cours
        return new Response($id);

    }

    #[IsGranted('ROLE_ADMIN', statusCode: 423)]
    #[Route('/{id}/archived', name: ('archived'))]
    public function archiveBook(int $id){
        $book = $this->em->getRepository(Book::class)->findOneBy(['id' => $id]);
        $book->setArchived(true);
        $this->em->persist($book);
        $this->em->flush();
        return $this->redirectToRoute('app_book_info', ['id' => $id]);
    }
}
