<?php

declare(strict_types=1);

namespace App\Training\Application;

readonly class CourseRegistry
{
    public function __construct(
        public string $studentId,
        public string $courseId,
    ) {
    }
}
