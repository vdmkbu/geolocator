<?php

namespace App\Geolocator\Tests;

use App\Geolocator\Types\Ip;
use PHPUnit\Framework\TestCase;

class IPTest extends TestCase
{
    /** @test */
    public function testIp4(): void
    {
        $ip = new Ip($value = '8.8.8.8');
        self::assertEquals($value, $ip->getValue());
    }

    /** @test */
    public function testInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        die(new Ip('IP incorrect'));
    }

    /** @test */
    public function testEmpty(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Ip('');
    }
}
