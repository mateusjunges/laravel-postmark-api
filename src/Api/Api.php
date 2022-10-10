<?php declare(strict_types=1);

namespace Ixdf\Postmark\Api;

use GuzzleHttp\ClientInterface;
use Ixdf\Postmark\Contracts\ApiResponse;
use Ixdf\Postmark\Contracts\Hydrator;
use Ixdf\Postmark\Exceptions\IncorrectApiTokenException;
use Ixdf\Postmark\Exceptions\PostmarkUnavailable;
use Ixdf\Postmark\Exceptions\ServerErrorException;
use Ixdf\Postmark\Exceptions\UnknownException;
use Psr\Http\Message\ResponseInterface;

abstract class Api
{
    public function __construct(
        protected readonly ClientInterface $client,
        protected readonly Hydrator $hydrator,
    ) {}

    /**
     * Hydrate the given response interface or throw an exception.
     *
     * @param  \Psr\Http\Message\ResponseInterface  $response
     * @param  class-string  $hydratorClass
     * @return \Ixdf\Postmark\Contracts\ApiResponse
     */
    protected function parseResponse(ResponseInterface $response, string $hydratorClass): ApiResponse
    {
        return match (true) {
            200 === $response->getStatusCode() => $this->hydrator->hydrate($response, $hydratorClass),
            401 === $response->getStatusCode() => throw new IncorrectApiTokenException($response->getBody()->getContents()),
            503 === $response->getStatusCode() => throw new PostmarkUnavailable($response->getBody()->getContents()),
            500 >= $response->getStatusCode() => throw new ServerErrorException($response->getBody()->getContents()),
            default => throw new UnknownException($response->getBody()->getContents())
        };
    }
}
