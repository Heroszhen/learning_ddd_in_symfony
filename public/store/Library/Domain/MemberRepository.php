<?php

declare(strict_types=1);

namespace App\Library\Domain;

interface MemberRepository
{
    public function get(string $id): Member;
    public function save(Member $member): void;
}
