<?php declare(strict_types=1);

namespace Ixdf\Postmark\Api;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Ixdf\Postmark\Contracts\ApiResponse;
use Ixdf\Postmark\Contracts\Hydrator;
use Ixdf\Postmark\Exceptions\HydrationException;
use Ixdf\Postmark\Exceptions\IncorrectApiTokenException;
use Ixdf\Postmark\Exceptions\PostmarkUnavailable;
use Ixdf\Postmark\Exceptions\ServerErrorException;
use Ixdf\Postmark\Exceptions\UnknownException;
use Ixdf\Postmark\Models\ErrorResponse;
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
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param class-string $hydratorClass
     * @return \Ixdf\Postmark\Contracts\ApiResponse
     */
    private function parseResponse(ResponseInterface $response, string $hydratorClass): ApiResponse
    {
        try {
            return $this->hydrator->hydrate($response, $hydratorClass);
        } catch (HydrationException) {}

        return match (true) {
            $response->getStatusCode() === 401 => throw new IncorrectApiTokenException($response->getBody()->getContents()),
            $response->getStatusCode() === 503 => throw new PostmarkUnavailable($response->getBody()->getContents()),
            $response->getStatusCode() >= 500 => throw new ServerErrorException($response->getBody()->getContents()),
            default => throw new UnknownException($response->getBody()->getContents())
        };
    }

    protected function request(string $method, string $uri, string $hydrateUsing, array $options = [], string $errorHydrator = ErrorResponse::class): ApiResponse
    {
        try {
            $response = $this->client->request($method, $uri, $options);
        } catch (ClientException $exception) {
            $response = $exception->getResponse();
            $hydrateUsing = $errorHydrator;
        }

        return $this->parseResponse($response, $hydrateUsing);
    }
}
