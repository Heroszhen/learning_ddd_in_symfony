<?php

declare(strict_types=1);

namespace App\Library\Ui;

use Symfony\Component\Validator\Constraints as Assert;

readonly class BookBorrowInput
{
    public function __construct(
        #[Assert\NotBlank]
        public string $memberId,
    ) {
    }
}
