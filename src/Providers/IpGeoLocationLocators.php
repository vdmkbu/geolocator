<?php

namespace App\Geolocator\Providers;


use App\Geolocator\Interfaces\Locator;
use App\Geolocator\Types\Ip;
use App\Geolocator\Types\Location;
use Psr\Http\Client\ClientInterface;
use Http\Message\MessageFactory\DiactorosMessageFactory;

class IpGeoLocationLocators implements Locator
{
    private $client;
    private $apiKey;

    public function __construct(ClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function locate(Ip $ip): ?Location
    {
        $url = 'https://api.ipgeolocation.io/ipgeo?' . http_build_query([
                'apiKey' => $this->apiKey,
                'ip' => $ip->getValue()
            ]);

        $request = (new DiactorosMessageFactory())->createRequest('GET', $url);
        $response = $this->client->sendRequest($request);

        $data = json_decode($response->getBody(), true);

        $data = array_map(function ($value) { return $value !== '-' ? $value : null;}, $data);

        if (empty($data['country_name'])) {
            return null;
        }

        return new Location($data['country_name'], $data['state_prov'], $data['city']);

    }
}