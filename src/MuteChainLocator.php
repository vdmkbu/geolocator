<?php

namespace App\Geolocator;


use App\Geolocator\Exceptions\PsrLogErrorHandler;
use App\Geolocator\Interfaces\Locator;
use App\Geolocator\Types\Ip;
use App\Geolocator\Types\Location;

class MuteChainLocator implements Locator
{
    private $next;
    private $handler;

    public function __construct(Locator $next, PsrLogErrorHandler $handler)
    {
        $this->next = $next;
        $this->handler = $handler;
    }

    public function locate(Ip $ip): ?Location
    {
       try {
           return $this->next->locate($ip);
       } catch (\RuntimeException $exception) {
           $this->handler->handle($exception);
           return null;
       }
    }
}