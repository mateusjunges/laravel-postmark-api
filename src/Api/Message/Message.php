<?php

namespace Ixdf\Postmark\Api\Message;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use Ixdf\Postmark\Contracts\Hydrator;
use Ixdf\Postmark\Exceptions\IncorrectApiTokenException;
use Ixdf\Postmark\Exceptions\PostmarkUnavailable;
use Ixdf\Postmark\Exceptions\ServerErrorException;
use Ixdf\Postmark\Exceptions\UnknownException;
use Ixdf\Postmark\Models\Message\SendBatchEmailResponse;

final class Message
{
    public function __construct(
        private ClientInterface $client,
        private Hydrator $hydrator,
    ) {}

    /**
     * @throws \Ixdf\Postmark\Exceptions\IncorrectApiTokenException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Ixdf\Postmark\Exceptions\ServerErrorException
     * @throws \Ixdf\Postmark\Exceptions\PostmarkUnavailable
     * @throws \Ixdf\Postmark\Exceptions\UnknownException
     */
    public function sendBatch(BatchCollection $batch)
    {
        $response = $this->client->request('POST', '/email/batch', [
            RequestOptions::BODY => $batch->toJson(),
            RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ]
        ]);

        return match ($response->getStatusCode()) {
            200 => $this->hydrator->hydrate($response, SendBatchEmailResponse::class),
            401 => throw new IncorrectApiTokenException(),
            500 => throw new ServerErrorException(),
            503 => throw new PostmarkUnavailable(),
            default => throw new UnknownException()
        };
    }
}
