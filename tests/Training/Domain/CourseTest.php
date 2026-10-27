<?php

declare(strict_types=1);

namespace App\Tests\Training\Domain;

use App\Training\Domain\Course;
use PHPUnit\Framework\TestCase;

class CourseTest extends TestCase
{
    public function testCreate(): void
    {
        $course = Course::create('11', 'name');

        $this->assertTrue($course instanceof Course);
    }

    public function testCreateWidthEmptyId(): void
    {
        $this->expectException(\DomainException::class);

        Course::create('', 'name');
    }

    public function testCreateWidthEmptyName(): void
    {
        $this->expectException(\DomainException::class);

        Course::create('id', '');
    }

    public function testCreateWidthNegativePlace(): void
    {
        $this->expectException(\DomainException::class);

        Course::create('id', 'name', -6);
    }

    public function testDefaultPlaces(): void
    {
        $course = Course::create('11', 'name');

        $this->assertSame(20, $course->getPlaces());
    }

    public function testAddStudentWidthTwoDifferentStudentAndOnePlace(): void
    {
        $course = Course::create('11', 'name', 1);
        $course->addStudent('1');

        $this->expectException(\DomainException::class);
        $course->addStudent('2');
    }

    public function testAddStudentWidthTwoSameStudent(): void
    {
        $course = Course::create('11', 'name', 2);
        $course->addStudent('1');

        $this->expectException(\DomainException::class);
        $course->addStudent('1');
    }

    public function testAddStudentWidthOneStudent(): void
    {
        $studentId = '2';
        $course = Course::create('11', 'name', 2);
        $course->addStudent($studentId);

        $this->assertContains($studentId, $course->getStudents());
    }
}
