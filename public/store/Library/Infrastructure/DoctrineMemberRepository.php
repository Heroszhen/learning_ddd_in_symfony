<?php

declare(strict_types=1);

namespace App\Library\Infrastructure;

use App\Library\Domain\Member;
use App\Library\Domain\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DoctrineMemberRepository implements MemberRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function get(string $memberId): Member
    {
        $member = $this->entityManager->getRepository(Member::class)->find($memberId);

        if (!$member instanceof Member) {
            throw EntityNotFoundException::fromClassNameAndIdentifier(Member::class, [$memberId]);
        }

        return $member;
    }

    public function save(Member $member): void
    {
        $this->entityManager->persist($member);
        $this->entityManager->flush();
    }
}
