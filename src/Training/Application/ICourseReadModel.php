<?php

declare(strict_types=1);

namespace App\Training\Application;

interface ICourseReadModel
{
    /** @return list<CourseViewModel> */
    public function findByFilters(array $filters): array;
    public function countFindByFilters(array $filters): int;
}
