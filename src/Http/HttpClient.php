<?php

namespace App\Geolocator\Http;


use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpClient implements ClientInterface
{
    public function get(string $url): ?string
    {
        $response = @file_get_contents($url);
        if ($response === false) {
            throw new \RuntimeException(error_get_last());
        }

        return $response;
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        // TODO: Implement sendRequest() method.
    }
}