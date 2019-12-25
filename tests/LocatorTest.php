<?php

namespace App\Geolocator\Tests;

use App\Geolocator\Locator;
use App\Geolocator\Types\Ip;
use PHPUnit\Framework\TestCase;

class LocatorTest extends TestCase
{
    /** @test */
    public function testSuccess(): void
    {
        $locator = new Locator();
        $location = $locator->locate(new Ip('8.8.8.8'));

        self::assertNotNull($location);
        self::assertEquals('United States', $location->getCountry());
        self::assertEquals('California', $location->getRegion());
        self::assertEquals('Mountain View', $location->getCity());
    }
}
