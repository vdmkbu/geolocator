<?php

namespace App\Geolocator\Providers;


use App\Geolocator\Interfaces\Locator;
use App\Geolocator\Types\Ip;
use App\Geolocator\Types\Location;

class IpInfoLocator implements Locator
{
    public function locate(Ip $ip): ?Location
    {

    }
}