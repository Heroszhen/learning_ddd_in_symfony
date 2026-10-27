<?php

declare(strict_types=1);

namespace App\Training\Domain;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'course')]
class Course
{
    private function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'guid')]
        private string $id,
        #[ORM\Column(length: 255, unique: true)]
        private string $name,
        #[ORM\Column]
        private int $places = 20,
        #[ORM\Column(type: 'json')]
        private array $studentIds = []
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

    public function getPlaces(): int
    {
        return $this->places;
    }

    public function getStudents(): array
    {
        return $this->studentIds;
    }

    public static function create(string $id, string $name, int $places = 20): self
    {
        if (empty($id) || empty($name)) {
            throw new \DomainException('Error');
        }

        if ($places < 1) {
            throw new \DomainException('Error');
        }

        return new self($id, $name, $places);
    }
}
