<?php

declare(strict_types=1);

namespace App\Library\Application;

use App\Library\Domain\BookRepository;
use App\Library\Domain\MemberRepository;

readonly class BookBorrowHandler
{
    public function __construct(
        private readonly BookRepository $bookRepository,
        private readonly MemberRepository $memberRepository,
    ) {
    }

    public function __invoke(BookBorrow $command): void
    {
        $member = $this->memberRepository->get($command->memberId);
        $member->borrowBook($command->bookId);

        $book = $this->bookRepository->get($command->bookId);
        $book->borrowBook($command->memberId);

        $this->memberRepository->save($member);
        $this->bookRepository->save($book);
    }
}
