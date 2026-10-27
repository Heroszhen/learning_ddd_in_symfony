<?php

declare(strict_types=1);

namespace App\Library\Domain;

interface BookRepository
{
    public function get(string $id): Book;
    public function save(Book $book): void;
}
