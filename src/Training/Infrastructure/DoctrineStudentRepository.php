<?php

declare(strict_types=1);

namespace App\Training\Infrastructure;

use App\Training\Domain\IStudentRepository;
use App\Training\Domain\Student;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DoctrineStudentRepository implements IStudentRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function get(string $id): Student
    {
        $student = $this->entityManager->getRepository(Student::class)->find($id);

        if (!$student instanceof Student) {
            throw EntityNotFoundException::fromClassNameAndIdentifier(Student::class, [$id]);
        }

        return $student;
    }
}
