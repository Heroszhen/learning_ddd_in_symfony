<?php

declare(strict_types=1);

namespace App\Library\Infrastructure;

use App\Library\Domain\Book;
use App\Library\Domain\BookRepository;
use Doctrine\DBAL\Connection;

final readonly class SqlBookRepository implements BookRepository
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function get(string $bookId): Book
    {
        $sql = 'SELECT * FROM book WHERE id = :id';
        $row = $this->connection->fetchAssociative(
            $sql,
            ['id' => $bookId]
        );

        if (false === $row) {
            throw new \DomainException(sprintf('%s: book not found', $bookId));
        }

        return Book::open(
            $row['id'],
            $row['title'],
            $row['member_id']
        );
    }

    public function save(Book $book): void
    {
        $this->connection->executeStatement(
            'INSERT INTO book (id, title, member_id)
             VALUES (:id, :title, :memberId)
             ON CONFLICT (id) DO UPDATE
                SET title = EXCLUDED.title,
                    member_id = EXCLUDED.member_id',
            [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'memberId' => $book->getMemberId(),
            ],
        );
    }
}
