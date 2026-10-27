<?php

declare(strict_types=1);

namespace App\Library\Domain;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'book')]
class Book
{
    private function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'guid')]
        private string $id,
        #[ORM\Column(length: 255)]
        private string $title,
        #[ORM\Column(type: 'guid', nullable: true)]
        private ?string $memberId = null
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getMemberId(): ?string
    {
        return $this->memberId;
    }

    public static function register(string $id, string $title): self
    {
        return new self($id, $title);
    }

    public function borrowBook(string $memberId): void
    {
        if (null !== $this->memberId) {
            throw new \DomainException('Not free');
        }

        $this->memberId = $memberId;
    }

    public function returnBook(string $memberId): void
    {
        if ($memberId !== $this->memberId) {
            throw new \DomainException('Not his book');
        }

        $this->memberId = null;
    }

    public static function open(string $id, string $title, ?string $memberId): self
    {
        return new self($id, $title, $memberId);
    }
}
