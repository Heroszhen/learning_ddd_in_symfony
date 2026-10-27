<?php

declare(strict_types=1);

namespace App\Training\Ui;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;

class CourseVoter extends Voter
{
    const EDIT = 'COURSE_EDIT';
    const REGISTRY = 'COURSE_REGISTRY';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the voter doesn't support this attribute, return false
        if (!in_array($attribute, [self::EDIT, self::REGISTRY])) {
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
