<?php

declare(strict_types=1);

namespace App\Library\Ui;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/courses/{id}/register',
            uriVariables: ['id'],
            read: false,
            output: false,
            status: 204,
            input: BookBorrowInput::class,
            security: "is_granted('BOOK_LEND')",
        ),
    ]
)]
final class CourseResource
{
    public function __construct(
        public string $id = '',
    ) {
    }
}
