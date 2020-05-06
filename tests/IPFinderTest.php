<?php

namespace App\Service;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class IPFinderTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnIp()
    {

        $httpClient = $this->createMock(Client::class);
        $reponse = $this->createMock(Response::class);

        $reponse->method('getBody')
            ->willReturn('127.0.0.1');

        $httpClient->method('request')
            ->willReturn($reponse);


        $ipFinder = new IPFinder($httpClient);

        $this->assertEquals('127.0.0.1', $ipFinder->findIp());
    }
}
