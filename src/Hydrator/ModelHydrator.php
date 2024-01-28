<?php declare(strict_types=1);

namespace Junges\Postmark\Hydrator;

use Junges\Postmark\Contracts\ApiResponse;
use Junges\Postmark\Contracts\Hydrator;
use Junges\Postmark\Exceptions\HydrationException;
use Psr\Http\Message\ResponseInterface;

final class ModelHydrator implements Hydrator
{
    public function hydrate(ResponseInterface $response, string $class)
    {
        $body = (string) $response->getBody();
        $contentType = $response->getHeaderLine('Content-Type');

        if (! str_starts_with($contentType, 'application/json') && ! str_starts_with($contentType, 'application/octet-stream')) {
            throw new HydrationException('The ModelHydrator cannot hydrate response with Content-Type: '.$contentType);
        }

        $data = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new HydrationException(
                sprintf(
                    'Error (%d) when trying to json_decode response',
                    json_last_error()
                )
            );
        }

        if (is_subclass_of($class, ApiResponse::class)) {
            return call_user_func([$class, 'create'], $data);
        }

        return new $class($data);
    }
}
