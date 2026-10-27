<?php

declare(strict_types=1);

namespace App\Training\Ui;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Training\Application\CourseRegistry;
use Symfony\Component\Messenger\MessageBusInterface;

class CourseRegistryProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly MessageBusInterface $queryBus
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $this->queryBus->dispatch(new CourseRegistry($data->studentId, $uriVariables['id']));
    }
}
