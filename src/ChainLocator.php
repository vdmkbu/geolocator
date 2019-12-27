<?php

namespace App\Geolocator;

use App\Geolocator\Interfaces\Locator;
use App\Geolocator\Types\Ip;
use App\Geolocator\Types\Location;

class ChainLocator implements Locator
{
    private $locators;

    public function __construct(Locator ...$locators)
    {
        $this->locators = $locators;
    }

    public function locate(Ip $ip): ?Location
    {
        $result = null;
        foreach ($this->locators as $locator) {
            $location = $locator->locate($ip);
            if ($location === null) {
                continue;
            }

            if ($location->getCity() !== null) {
                return $location;
            }

            if ($result === null && $location->getRegion() !== null) {
                $result = $location;
                continue;
            }

            if ($result === null || $location->getRegion() === null) {
                $result = $location;
            }

        }

        return $result;
    }
}