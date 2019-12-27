<?php

namespace App\Geolocator\Tests;

use App\Geolocator\ChainLocator;
use App\Geolocator\Interfaces\Locator;
use App\Geolocator\Types\Ip;
use App\Geolocator\Types\Location;
use PHPUnit\Framework\TestCase;

class ChainLocatorTest extends TestCase
{
    /** @test */
    public function testSuccess(): void
    {
        $locators = [
            $this->mockLocator(null),
            $this->mockLocator($expected = new Location('Expected','1','2')),
            $this->mockLocator(null),
            $this->mockLocator(new Location('Other','1','2')),
            $this->mockLocator(null)

        ];

        $locator = new ChainLocator(...$locators);
        $actual = $locator->locate(new Ip('8.8.8.8'));

        self::assertNotNull($actual);
        self::assertEquals($expected, $actual);
    }

    private function mockLocator(?Location $location): Locator
    {
        $mock = $this->createMock(Locator::class);
        $mock->method('locate')->willReturn($location);
        return $mock;
    }
}
