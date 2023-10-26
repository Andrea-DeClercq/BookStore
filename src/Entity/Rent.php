<?php

namespace App\Entity;

use App\Repository\RentRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RentRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Rent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $borrowedDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $returnDate = null;

    #[ORM\ManyToOne(inversedBy: 'rents')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'rents')]
    private ?Book $book = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorrowedDate(): ?\DateTimeInterface
    {
        return $this->borrowedDate;
    }

    #[ORM\PrePersist]
    public function setBorrowedDate(): void
    {
        $this->borrowedDate = new DateTime();
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->returnDate;
    }

    #[ORM\PrePersist]
    public function setReturnDate(): void
    {
        $this->returnDate = new DateTime('+2 weeks');
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): static
    {
        $this->book = $book;

        return $this;
    }
}
