<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Book
{
    public const NEW = 'Neuf';
    public const SLIGHTLY_SCRATCHED = 'Légèrement écorché';
    public const FOLDED = 'Plié';
    public const DEFORMED = 'Déformé';
    public const DAMAGED_COVER = 'Couverture abîmé';
    public const FRAGILE = 'Fragile';
    public const MISSING_PAGES = 'Pages manquantes';
    public const PENCIL_MARK = 'Marques de crayon';
    public const OCCASION = 'Occasion';
    public const CORRECT = 'Correct';
    public const STATUS = [
        self::NEW => 'Neuf',
        self::SLIGHTLY_SCRATCHED => 'Légèrement écorché',
        self::FOLDED => 'Plié',
        self::DEFORMED => 'Déformé',
        self::DAMAGED_COVER => 'Couverture abîmé',
        self::FRAGILE => 'Fragile',
        self::MISSING_PAGES => 'Pages manquantes',
        self::PENCIL_MARK => 'Marque de crayon',
        self::OCCASION => 'Occasion',
        self::CORRECT => 'Correct',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $release_date = null;

    #[ORM\Column()]
    private ?bool $archived = false;

    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'books')]
    private Collection $authors;

    #[ORM\OneToOne(mappedBy: 'borrow_book', cascade: ['persist', 'remove'])]
    private ?Rent $rent = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->authors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(?\DateTimeInterface $release_date): static
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function isArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(?bool $archived): static
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthors(): Collection
    {
        return $this->authors;
    }

    public function addAuthor(Author $author): static
    {
        if (!$this->authors->contains($author)) {
            $this->authors->add($author);
        }

        return $this;
    }

    public function removeAuthor(Author $author): static
    {
        $this->authors->removeElement($author);

        return $this;
    }

    public function getRent(): ?Rent
    {
        return $this->rent;
    }

    public function setRent(?Rent $rent): static
    {
        // unset the owning side of the relation if necessary
        if ($rent === null && $this->rent !== null) {
            $this->rent->setBorrowBook(null);
        }

        // set the owning side of the relation if necessary
        if ($rent !== null && $rent->getBorrowBook() !== $this) {
            $rent->setBorrowBook($this);
        }

        $this->rent = $rent;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PreUpdate]
    public function setUpdateAt(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
