<?php

declare(strict_types=1);

namespace App\Training\Domain;

interface ICourseRepository
{
    public function get(string $id): Course;
}
