<?php

declare(strict_types=1);

namespace App\Training\Infrastructure;

use App\Training\Application\CourseViewModel;
use App\Training\Application\ICourseReadModel;
use Doctrine\DBAL\Connection;

final readonly class DbalCourseReadModel implements ICourseReadModel
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function findByFilters(array $filters): array
    {
        $page = (int) max(1, $filters['page'] ?? 1);
        $page = "ab";
        $sql = 'SELECT id, name, places, student_ids
                FROM Course
                ORDER BY id
                LIMIT :limit OFFSET :offset';
        $rows = $this->connection->fetchAllAssociative(
            $sql,
            ['limit' => 20, 'offset' => ($page - 1) * 20]
        );

        return array_map(
            function ($row): CourseViewModel {
                return new CourseViewModel(
                    $row['id'],
                    $row['name'],
                    $row['places'],
                    json_decode($row['student_ids'], true)
                );
            },
            $rows
        );
    }

    public function countFindByFilters(array $filters): int
    {
        $sql = 'SELECT count(id)FROM Course';

        return (int)$this->connection->fetchOne($sql);
    }
}
