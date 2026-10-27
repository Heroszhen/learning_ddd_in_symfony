<?php

namespace App\Factory;

use App\Training\Domain\Student;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;
use Symfony\Component\Uid\Uuid;

/**
 * @extends PersistentObjectFactory<Student>
 */
final class StudentFactory extends PersistentObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    #[\Override]
    public static function class(): string
    {
        return Student::class;
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
            'name' => self::faker()->unique()->name(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this->instantiateWith(
            static fn (array $attributes): Student => Student::create(
                $attributes['id'],
                $attributes['name'],
            ),
        );
    }
}
