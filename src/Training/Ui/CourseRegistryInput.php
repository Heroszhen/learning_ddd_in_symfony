<?php

declare(strict_types=1);

namespace App\Training\Ui;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CourseRegistryInput
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Uuid]
        public string $studentId,
    ) {
    }
}
