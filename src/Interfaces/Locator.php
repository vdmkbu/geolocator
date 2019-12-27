<?php

namespace App\Geolocator\Interfaces;


use App\Geolocator\Types\Ip;
use App\Geolocator\Types\Location;

interface Locator
{
    public function locate(Ip $ip): ?Location;
}