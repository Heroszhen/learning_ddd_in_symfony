<?php

declare(strict_types=1);

namespace App\Training\Application;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CourseViewHandler
{
    public function __construct(
        private readonly ICourseReadModel $courseReadModel,
    ) {
    }

    public function __invoke(CourseView $message): array
    {
        return [
            'courses' => $this->courseReadModel->findByFilters($message->filters),
            'total' => $this->courseReadModel->countFindByFilters($message->filters),
        ];
    }
}
