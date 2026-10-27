<?php

declare(strict_types=1);

namespace App\Library\Ui;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;

class BookVoter extends Voter
{
    const EDIT = 'BOOK_EDIT';
    const LEND = 'BOOK_LEND';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the voter doesn't support this attribute, return false
        if (!in_array($attribute, [self::EDIT, self::LEND])) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $roles = $token->getUser()?->getRoles();

        return is_array($roles) && in_array('ROLE_ADMIN', $roles, true);
    }
}
