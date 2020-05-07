<?php

namespace App\Service;

use App\Entity\Location;
use App\Exception\ErrorOnFindingLocation;
use DateTimeZone;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class LocationFinderTest extends TestCase
{
    private $httpClient;
    private $response;
    private $locationFinder;

    public function setUp()
    {
        $this->httpClient = $this->createMock(Client::class);
        $this->response = $this->createMock(Response::class);
        $this->locationFinder = new LocationFinder($this->httpClient);
    }

    /**
     * @test
     */
    public function shouldReturnExceptionWhenRequestStatusCodeNotOk()
    {
        $this->response->method('getStatusCode')
            ->willReturn(404);

        $this->httpClient->method('request')
            ->willReturn($this->response);

        $this->expectException(ErrorOnFindingLocation::class);

        $this->locationFinder->findLocation('127.0.0.1');
    }

    /**
     * @test
     */
    public function shouldReturnLocationWhenRequestStatusCodeOk()
    {
        $location = [
            'continent_code' => 'NA',
            'country_name' => 'United States',
            'city' => 'New York',
            'timezone' => DateTimeZone::AMERICA
        ];

        $this->response->method('getStatusCode')
            ->willReturn(200);

        $this->response->method('getBody')
            ->willReturn(json_encode($location));

        $this->httpClient->method('request')
            ->willReturn($this->response);

        $this->assertInstanceOf(Location::class, $this->locationFinder->findLocation('127.0.0.1'));
    }
}
