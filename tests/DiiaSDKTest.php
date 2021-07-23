<?php

namespace Sinnrrr\Diia\Tests;

use Mockery;
use Sinnrrr\Diia\Diia;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client as HttpClient;

class DiiaSDKTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_making_basic_requests()
    {
        $diia = new Diia('token', $http = Mockery::mock(HttpClient::class));

        $http->shouldReceive('request')
            ->once()
            ->with('GET', 'v2/acquirers/branches')
            ->andReturn(
                $response = Mockery::mock(Response::class)
            );

        $response->shouldReceive('getStatusCode')
            ->once()
            ->andReturn(401);

        $response->shouldReceive('getBody')
            ->once()
            ->andReturn([
                "name" => "Error",
                "message" => "Not authorized",
                "code" => 401,
                "data" => []
            ]);
    }
}
