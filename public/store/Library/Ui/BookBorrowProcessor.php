<?php

declare(strict_types=1);

namespace App\Library\Ui;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Library\Application\BookBorrow;
use App\Library\Application\BookBorrowHandler;

class BookBorrowProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly BookBorrowHandler $handler,
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        ($this->handler)(new BookBorrow($uriVariables['id'], $data->memberId));
    }
}
