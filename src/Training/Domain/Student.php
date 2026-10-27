<?php

declare(strict_types=1);

namespace App\Training\Domain;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'student')]
class Student
{
    private function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'guid')]
        private string $id,
        #[ORM\Column(length: 255, unique: true)]
        private string $name,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function create(string $id, string $name): self
    {
        if (empty($id) || empty($name)) {
            throw new \DomainException('Error');
        }

        return new self($id, $name);
    }
}
