<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
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

    public function rentBook(int $id){
        # Affecte le livre en tant qu'emprunt à l'utilisateur en cours
        return new Response($id);

    }

    public function returnBook(int $id){
        # Retourne le livre & l'affiche de nouveau dans la liste
        return new Response($id);

    }

    public function myBooks(){
        # Retourne la liste des emprunts de l'utilisateur en cours
        return new Response($id);

    }
}
