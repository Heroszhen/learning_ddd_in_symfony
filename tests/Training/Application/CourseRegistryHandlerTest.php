<?php

declare(strict_types=1);

namespace App\Tests\Training\Application;

use App\Training\Application\CourseRegistry;
use App\Training\Application\CourseRegistryHandler;
use App\Training\Domain\Course;
use App\Training\Domain\ICourseRepository;
use App\Training\Domain\IStudentRepository;
use App\Training\Domain\Student;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class CourseRegistryHandlerTest extends TestCase
{
    #[DataProvider('studentsNotInCoursProvider')]
    public function testStudentsNotInCourse(Student $student, Course $course): void
    {
        $studentRepository = $this->createStub(IStudentRepository::class);
        $studentRepository->method('get')->willReturn($student);

        $courseRepository = $this->createMock(ICourseRepository::class);
        $courseRepository->method('get')->willReturn($course);
        $courseRepository->expects(self::once())->method('save')->with($course);

        $handler = new CourseRegistryHandler($studentRepository, $courseRepository);

        $handler(new CourseRegistry($student->getId(), $course->getId()));

        $this->assertContains($student->getId(), $course->getStudents());
    }

    public static function studentsNotInCoursProvider(): array
    {
        return [
            [
                Student::create('1', 'student1'),
                Course::create('1', 'course1')
            ],
            [
                Student::create('2', 'student2'),
                Course::create('2', 'course2')
            ],
        ];
    }
}
