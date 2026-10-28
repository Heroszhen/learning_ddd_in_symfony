<?php

declare(strict_types=1);

namespace App\Tests\Training\Infrastructure;

use App\Training\Domain\Course;
use App\Training\Infrastructure\DoctrineCourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;

class DoctrineCourseRepositoryTest extends TestCase
{
    public function testGetWithExistedCourse(): void
    {
        $course = Course::create('1', 'course1');

        $entityRepository = $this->createStub(EntityRepository::class);
        $entityRepository->method('find')->willReturn($course);

        $entityManager = $this->createStub(EntityManagerInterface::class);
        $entityManager->method('getRepository')->willReturn($entityRepository);

        $courseRepository = new DoctrineCourseRepository($entityManager);
        $foundCourse = $courseRepository->get($course->getId());

        $this->assertSame($course->getId(), $foundCourse->getId());
    }

    public function testGetWithUnknownCourse(): void
    {
        $entityRepository = $this->createStub(EntityRepository::class);
        $entityRepository->method('find')->willReturn(null);

        $entityManager = $this->createStub(EntityManagerInterface::class);
        $entityManager->method('getRepository')->willReturn($entityRepository);

        $courseRepository = new DoctrineCourseRepository($entityManager);

        $this->expectException(\RuntimeException::class);
        $courseRepository->get('unknown');
    }
}
