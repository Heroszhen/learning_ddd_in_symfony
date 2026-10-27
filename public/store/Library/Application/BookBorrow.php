<?php

declare(strict_types=1);

namespace App\Library\Application;

readonly class BookBorrow
{
    public function __construct(
        public string $bookId,
        public string $memberId,
    ) {
    }
}
