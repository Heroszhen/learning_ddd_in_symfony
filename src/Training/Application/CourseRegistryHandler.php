<?php

declare(strict_types=1);

namespace App\Training\Application;

use App\Training\Application\CourseRegistry;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CourseRegistryHandler
{
    public function __construct()
    {
    }

    public function __invoke(CourseRegistry $message): void
    {
        //get student and course

        //check if the student is in the course

        //add student in course
    }
}
