<?php

declare(strict_types=1);

namespace App\Training\Ui;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\Pagination\TraversablePaginator;
use ApiPlatform\State\ProviderInterface;
use App\Training\Application\CourseView;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class CourseProvider implements ProviderInterface
{
    use HandleTrait;

    public function __construct(
        private readonly MessageBusInterface $bus
    ) {
        $this->messageBus = $bus;
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): TraversablePaginator
    {
        $filters = $context['filters'] ?? [];
        $tab =  $this->handle(new CourseView($filters));
        $page = (int) max(1, $filters['page'] ?? 1);

        return new TraversablePaginator(
            new \ArrayIterator($tab['courses']),
            $page,
            20,
            $tab['total'],
        );
    }
}
