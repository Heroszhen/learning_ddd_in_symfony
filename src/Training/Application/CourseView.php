<?php

declare(strict_types=1);

namespace App\Training\Application;

final readonly class CourseView
{
    public function __construct(
        public array $filters
    ) {
    }
}
