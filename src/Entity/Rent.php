<?php

namespace App\Entity;

use App\Repository\RentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RentRepository::class)]
class Rent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $borrow_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $return_date = null;

    #[ORM\OneToOne(inversedBy: 'rent', cascade: ['persist', 'remove'])]
    private ?Book $borrow_book = null;

    #[ORM\ManyToOne(inversedBy: 'rents')]
    private ?User $borrowed_by = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorrowDate(): ?\DateTimeInterface
    {
        return $this->borrow_date;
    }

    public function setBorrowDate(?\DateTimeInterface $borrow_date): static
    {
        $this->borrow_date = $borrow_date;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->return_date;
    }

    public function setReturnDate(?\DateTimeInterface $return_date): static
    {
        $this->return_date = $return_date;

        return $this;
    }

    public function getBorrowBook(): ?Book
    {
        return $this->borrow_book;
    }

    public function setBorrowBook(?Book $borrow_book): static
    {
        $this->borrow_book = $borrow_book;

        return $this;
    }

    public function getBorrowedBy(): ?User
    {
        return $this->borrowed_by;
    }

    public function setBorrowedBy(?User $borrowed_by): static
    {
        $this->borrowed_by = $borrowed_by;

        return $this;
    }
}
