<?php

declare(strict_types=1);

namespace App\Training\Application;

final readonly class CourseViewModel
{
    public function __construct(
        public string $id,
        public string $name,
        public int $places,
        public array $studentIds,
    ) {
    }
}
