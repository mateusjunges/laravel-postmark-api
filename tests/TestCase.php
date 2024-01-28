<?php

namespace Junges\Postmark\Tests;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Junges\Postmark\Providers\PostmarkServiceProvider;
use Mockery as m;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function getPackageProviders($app): array
    {
        return [
            PostmarkServiceProvider::class
        ];
    }

    protected function mockOneRequest(string $expectedMethod = 'get', string $response = "", int $responseCode = 200, array $headers = []): void
    {
        $clientMock = m::mock(Client::class);
        $clientMock->shouldReceive($expectedMethod)
            ->once()
            ->andReturn(
                new Response($responseCode, $headers + ['Content-Type' => 'application/json'], $response)
            );

        $this->app->instance(Client::class, $clientMock);
    }

    protected function mockThrowException($expectedMethod = 'get', $exceptionMessage = 'Exception Message', $exceptionCode = 12345, $exceptionClass = Exception::class)
    {
        $clientMock = m::mock(Client::class);

        $clientMock->shouldReceive($expectedMethod)->andThrow($exceptionClass, $exceptionMessage, $exceptionCode);

        $this->app->instance(Client::class, $clientMock);
    }
}
