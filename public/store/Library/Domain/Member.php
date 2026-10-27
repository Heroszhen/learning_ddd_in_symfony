<?php

declare(strict_types=1);

namespace App\Library\Domain;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'member')]
class Member
{
    private function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'guid')]
        private string $id,
        #[ORM\Column(length: 255)]
        private string $email,
        #[ORM\Column(type: 'guid', nullable: true)]
        private ?string $bookId = null
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBookId(): ?string
    {
        return $this->bookId;
    }

    public static function register(string $id, string $email): self
    {
        return new self($id, $email);
    }

    public function borrowBook(string $bookId): void
    {
        if (null !== $this->bookId) {
            throw new \DomainException('He has one book');
        }

        $this->bookId = $bookId;
    }

    public function returnBook(string $bookId): void
    {
        if ($bookId !== $this->bookId) {
            throw new \DomainException('Not his book');
        }

        $this->bookId = null;
    }
}
