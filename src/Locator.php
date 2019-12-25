<?php

namespace App\Geolocator;


use App\Geolocator\Types\Ip;
use App\Geolocator\Types\Location;

class Locator
{
    public function locate(Ip $ip): ?Location
    {


        $url = 'https://api.ipgeolocation.io/ipgeo?' . http_build_query([
            'apiKey' => 'e81b3531074e45cc830a7058da6e1620',
            'ip' => $ip->getValue()
        ]);

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        $data = array_map(function ($value) { return $value !== '-' ? $value : null;}, $data);

        if (empty($data['country_name'])) {
            return null;
        }

        return new Location($data['country_name'], $data['state_prov'], $data['city']);

    }
}