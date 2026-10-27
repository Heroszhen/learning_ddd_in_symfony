<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Security;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity]
#[ORM\Table(name: 'app_user')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @param list<string> $roles
     */
    private function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'guid')]
        private string $id,
        #[ORM\Column(length: 180, unique: true)]
        private string $email,
        #[ORM\Column]
        private string $password,
        #[ORM\Column(type: 'json')]
        private array $roles = ['ROLE_USER'],
    ) {
    }

    /**
     * @param list<string> $roles
     */
    public static function create(string $id, string $email, string $hashedPassword, array $roles = ['ROLE_USER']): self
    {
        return new self($id, $email, $hashedPassword, $roles);
    }

    public function getId(): string
    {
        return $this->id;
    }

    // l'identifiant utilisé pour se connecter
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        // tout utilisateur connecté a au moins ROLE_USER
        return array_values(array_unique([...$this->roles, 'ROLE_USER']));
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
