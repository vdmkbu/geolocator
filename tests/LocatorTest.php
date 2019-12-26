<?php

namespace App\Geolocator\Tests;

use App\Geolocator\Http\HttpClient;
use App\Geolocator\Locator;
use App\Geolocator\Types\Ip;
use PHPUnit\Framework\TestCase;

class LocatorTest extends TestCase
{
    /** @test */
    public function testSuccess(): void
    {
        $client = $this->createMock(HttpClient::class);
        $client->method('get')->willReturn(json_encode([
            'country_name' => 'United States',
            'state_prov' => 'California',
            'city' => 'Mountain View'
        ]));

        $locator = new Locator($client, 'e81b3531074e45cc830a7058da6e1620');
        $location = $locator->locate(new Ip('8.8.8.8'));

        self::assertNotNull($location);
        self::assertEquals('United States', $location->getCountry());
        self::assertEquals('California', $location->getRegion());
        self::assertEquals('Mountain View', $location->getCity());
    }
}
