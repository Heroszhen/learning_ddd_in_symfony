<?php

declare(strict_types=1);

namespace App\Training\Ui;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Training\Ui\CourseRegistryInput;
use App\Training\Ui\CourseRegistryProcessor;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/courses',
            security: "is_granted('ROLE_USER')",
            provider: CourseProvider::class
        ),
        new Post(
            uriTemplate: '/courses/{id}/registry',
            uriVariables: ['id'],
            read: false,
            output: false,
            processor: CourseRegistryProcessor::class,
            status: 204,
            input: CourseRegistryInput::class,
            security: "is_granted('COURSE_REGISTRY')",
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
