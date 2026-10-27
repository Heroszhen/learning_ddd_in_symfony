<?php

declare(strict_types=1);

namespace App\Training\Domain;

interface IStudentRepository
{
    public function get(string $id): Student;
}
