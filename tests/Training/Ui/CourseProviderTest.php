<?php

declare(strict_types=1);

namespace App\Tests\Training\Ui;

use ApiPlatform\Metadata\GetCollection;
use App\Training\Ui\CourseProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Training\Application\CourseView;
use App\Training\Domain\Course;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class CourseProviderTest extends TestCase
{
    public function getBus(array $filters = [], array $courses = []): MessageBusInterface
    {
        $bus = $this->createMock(MessageBusInterface::class);
        $bus
            ->expects(self::once())
            ->method('dispatch')
            ->willReturn(new Envelope(
                new CourseView($filters),
                [
                    new HandledStamp([
                        'courses' => $courses,
                        'total' => count($courses),
                    ], 'test_handler'),
                ],
            ));

        return $bus;
    }

    public function testWithEmptyPage(): void
    {
        $provider = new CourseProvider($this->getBus());
        $paginator = $provider->provide(
            new GetCollection(),
            [],
            []
        );

        $this->assertSame(1.0, $paginator->getCurrentPage());
    }

    public function testWithNegativePage(): void
    {
        $filters = ['page' => -1];
        $provider = new CourseProvider($this->getBus($filters));
        $paginator = $provider->provide(
            new GetCollection(),
            [],
            ['filters' => $filters]
        );

        $this->assertSame(1.0, $paginator->getCurrentPage());
    }

    public function testWithPositivePage(): void
    {
        $filters = ['page' => 5];
        $provider = new CourseProvider($this->getBus($filters));
        $paginator = $provider->provide(
            new GetCollection(),
            [],
            ['filters' => $filters]
        );

        $this->assertSame(5.0, $paginator->getCurrentPage());
    }

    public function testWithPositivePage2(): void
    {
        $courses = [];
        for ($i = 0; $i < 10; $i++) {
            $courses[] = Course::create((string) ($i + 1), 'course' . $i);
        }

        $filters = ['page' => 2];
        $provider = new CourseProvider($this->getBus($filters, $courses));
        $paginator = $provider->provide(
            new GetCollection(),
            [],
            ['filters' => $filters]
        );

        self::assertSame($courses, iterator_to_array($paginator));
        self::assertSame(10.0, $paginator->getTotalItems());
    }
}
