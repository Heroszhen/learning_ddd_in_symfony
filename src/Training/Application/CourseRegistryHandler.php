<?php

declare(strict_types=1);

namespace App\Training\Application;

use App\Training\Application\CourseRegistry;
use App\Training\Domain\ICourseRepository;
use App\Training\Domain\IStudentRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CourseRegistryHandler
{
    public function __construct(
        private readonly IStudentRepository $studentRepository,
        private readonly ICourseRepository $courseRepository,
    ) {
    }

    public function __invoke(CourseRegistry $message): void
    {
        //get student and course
        $student = $this->studentRepository->get($message->studentId);
        $course = $this->courseRepository->get($message->courseId);

        //check if the student is in the course and add student in course
        $course->addStudent($student->getId());

        //save course
        $this->courseRepository->save($course);
    }
}
