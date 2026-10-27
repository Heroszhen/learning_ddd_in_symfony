<?php

namespace App\Factory;

use App\Shared\Infrastructure\Security\User;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;
use Symfony\Component\Uid\Uuid;

/**
 * @extends PersistentObjectFactory<User>
 */
final class UserFactory extends PersistentObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(
        private readonly PasswordHasherFactoryInterface $hashers,
    ) {
    }

    #[\Override]
    public static function class(): string
    {
        return User::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'id' => Uuid::v7()->toRfc4122(),
            'email' => self::faker()->unique()->email(),
            'password' => $this->hashers->getPasswordHasher(User::class)->hash('aaaaaaaa'),
            'roles' => ['ROLE_USER'],
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this->instantiateWith(
            static fn (array $attributes): User => User::create(
                $attributes['id'],
                $attributes['email'],
                $attributes['password'],
                $attributes['roles'],
            ),
        );
    }
}
