<?php

namespace App\Service;

use App\Exception\InvalidIP4Format;
use PHPUnit\Framework\TestCase;

class IPFizzBuzzTest extends TestCase
{
    private $ipFizzBuzz;

    public function setUp()
    {
        $this->ipFizzBuzz = new IPFizzBuzz();
    }

    /**
     * @test
     * @dataProvider fizzBuzzDataProvider
     */
    public function shoulReturnResponse($expectedResponse, $ip)
    {
        $this->assertEquals($expectedResponse, $this->ipFizzBuzz->getFizzBuzzByIP($ip));
    }

    /**
     * @test
     * @dataProvider ipFormatProvider
     */
    public function shouldReturnInvalidIP4Format($ip)
    {
        $this->expectException(InvalidIP4Format::class);

        $this->ipFizzBuzz->getFizzBuzzByIP($ip);
    }

    public function fizzBuzzDataProvider()
    {
        return [
            'shouldReturnFizz' => ['Fizz', '127.0.0.3'],
            'shouldReturnBuzz' => ['Buzz', '127.0.0.55'],
            'shouldReturnFizzBuzz' => ['FizzBuzz', '127.0.0.15'],
            'shouldReturnLastGroupOfIp' => ["2", '127.0.0.2']
        ];
    }

    public function ipFormatProvider()
    {
        return [
            'shouldReturnExcepitonWhenThirdPartOfIpIsNotAnumber' => ["127.0.0.0e"],
            'shouldReturnExceptionWhenPartsOfIpDifferentOfFour' => ["127.0.0.3.4"],
        ];
    }
}
