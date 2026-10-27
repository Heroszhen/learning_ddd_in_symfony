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

    #[DataProvider('studentsInCoursProvider')]
    public function testStudentsInCourse(Student $student, Course $course): void
    {
        $course->addStudent($student->getId());

        $studentRepository = $this->createStub(IStudentRepository::class);
        $studentRepository->method('get')->willReturn($student);

        $courseRepository = $this->createMock(ICourseRepository::class);
        $courseRepository->method('get')->willReturn($course);
        $courseRepository->expects(self::never())->method('save')->with($course);

        $handler = new CourseRegistryHandler($studentRepository, $courseRepository);

        $this->expectException(\DomainException::class);

        $handler(new CourseRegistry($student->getId(), $course->getId()));
    }

    public static function studentsInCoursProvider(): array
    {
        return [
            [
                Student::create('3', 'student3'),
                Course::create('3', 'course3')
            ],
        ];
    }

    #[DataProvider('CoursNotFreeProvider')]
    public function testCourseNotFree(Student $student, Course $course): void
    {
        $course->addStudent('6');

        $studentRepository = $this->createStub(IStudentRepository::class);
        $studentRepository->method('get')->willReturn($student);

        $courseRepository = $this->createMock(ICourseRepository::class);
        $courseRepository->method('get')->willReturn($course);
        $courseRepository->expects(self::never())->method('save')->with($course);

        $handler = new CourseRegistryHandler($studentRepository, $courseRepository);

        $this->expectException(\DomainException::class);

        $handler(new CourseRegistry($student->getId(), $course->getId()));
    }

    public static function CoursNotFreeProvider(): array
    {
        return [
            [
                Student::create('4', 'student4'),
                Course::create('4', 'course4', 1)
            ],
        ];
    }

    public function testUnknownStudent(): void
    {
        $studentRepository = $this->createStub(IStudentRepository::class);
        $studentRepository->method('get')->willThrowException(new \RuntimeException('Student not found'));

        $courseRepository = $this->createMock(ICourseRepository::class);
        $courseRepository->expects(self::never())->method('save');

        $handler = new CourseRegistryHandler($studentRepository, $courseRepository);

        $this->expectException(\RuntimeException::class);

        $handler(new CourseRegistry('1', '2'));
    }
}
