<?php

namespace App\Geolocator\Tests;

use PHPUnit\Framework\TestCase;
use Http\Mock\Client;
use Psr\Http\Message\RequestInterface;

class LocatorTest extends TestCase
{
    /** @test */
    public function testSuccess(): void
    {

        $client = new Client();

        $response = $this->createMock('Psr\Http\Message\ResponseInterface');
        $client->addResponse($response);


        $request = $this->createMock(RequestInterface::class);
        $returnedResponse = $client->sendRequest($request);

        $this->assertSame($response, $returnedResponse);
        $this->assertSame($request, $client->getLastRequest());
    }
}
