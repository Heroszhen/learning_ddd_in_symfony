<?php

declare(strict_types=1);

namespace App\Training\Infrastructure;

use App\Training\Domain\Course;
use App\Training\Domain\ICourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DoctrineCourseRepository implements ICourseRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function get(string $id): Course
    {
        $course = $this->entityManager->getRepository(Course::class)->find($id);

        if (!$course instanceof Course) {
            throw EntityNotFoundException::fromClassNameAndIdentifier(Course::class, [$id]);
        }

        return $course;
    }

    public function save(Course $course): void
    {
        $this->entityManager->persist($course);
        $this->entityManager->flush();
    }
}
