<?php

namespace App\Geolocator\Tests;

;
use App\Geolocator\CacheLocator;
use App\Geolocator\ChainLocator;
use App\Geolocator\Exceptions\PsrLogErrorHandler;
use App\Geolocator\Interfaces\Locator;
use App\Geolocator\MuteChainLocator;
use App\Geolocator\Types\Ip;
use App\Geolocator\Types\Location;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

class CacheChainLocatorTest extends TestCase
{
    /** @test */
    public function testSuccess()
    {
        $locators = [
            $this->mockLocator(null),
            $this->mockLocator($expected = new Location('Expected','1','2')),
            $this->mockLocator(null),
            $this->mockLocator(new Location('Other','1','2')),
            $this->mockLocator(null)

        ];

        $logger = $client = $this->createMock(LoggerInterface::class);
        $handler = new PsrLogErrorHandler($logger);

        $cache = $this->createMock(CacheInterface::class);

        $locator = new ChainLocator(
            new CacheLocator(
                new MuteChainLocator($locators[0], $handler),
                $cache,
                'cache_1',
                3600),
            new CacheLocator(
                new MuteChainLocator($locators[1], $handler),
                $cache,
                'cache_2',
                3600)
        );

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
