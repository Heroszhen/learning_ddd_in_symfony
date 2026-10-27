<?php

namespace App\Factory;

use App\Training\Domain\Course;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;
use Symfony\Component\Uid\Uuid;

/**
 * @extends PersistentObjectFactory<Course>
 */
final class CourseFactory extends PersistentObjectFactory
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
        return Course::class;
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
            'name' => self::faker()->unique()->words(3, true),
            'places' => self::faker()->numberBetween(2, 10),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this->instantiateWith(
            static fn (array $attributes): Course => Course::create(
                $attributes['id'],
                $attributes['name'],
                $attributes['places'],
            ),
        );
    }
}
