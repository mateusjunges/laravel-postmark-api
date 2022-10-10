<?php declare(strict_types=1);

namespace Ixdf\Postmark\Api\Message;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use Ixdf\Postmark\Api\Message\Requests\Batch;
use Ixdf\Postmark\Api\Message\Requests\BatchWithTemplate;
use Ixdf\Postmark\Api\Message\Requests\EmailWithTemplate;
use Ixdf\Postmark\Api\Message\Requests\Message as MessageRequest;
use Ixdf\Postmark\Contracts\ApiResponse;
use Ixdf\Postmark\Contracts\Hydrator;
use Ixdf\Postmark\Contracts\MessageApi;
use Ixdf\Postmark\Exceptions\IncorrectApiTokenException;
use Ixdf\Postmark\Exceptions\PostmarkUnavailable;
use Ixdf\Postmark\Exceptions\ServerErrorException;
use Ixdf\Postmark\Exceptions\UnknownException;
use Ixdf\Postmark\Models\Message\SendResponse;
use Ixdf\Postmark\Models\Message\SendBatchResponse;
use Ixdf\Postmark\Models\Message\SendBatchWithTemplateResponse;
use Ixdf\Postmark\Models\Message\SendWithTemplateResponse;
use Psr\Http\Message\ResponseInterface;

final class Message implements MessageApi
{
    public function __construct(
        private readonly ClientInterface $client,
        private readonly Hydrator $hydrator,
    ) {}

    /**
     * Send a given message.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(MessageRequest $message): ApiResponse
    {
        return $this->parseResponse(
            $this->client->request('POST', '/email', [
                RequestOptions::BODY => $message->toJson()
            ]),
            SendResponse::class
        );
    }

    /**
     * Send a batch of emails.
     *
     * @throws \Ixdf\Postmark\Exceptions\IncorrectApiTokenException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Ixdf\Postmark\Exceptions\ServerErrorException
     * @throws \Ixdf\Postmark\Exceptions\PostmarkUnavailable
     * @throws \Ixdf\Postmark\Exceptions\UnknownException
     */
    public function sendBatch(Batch $batch): ApiResponse
    {
        return $this->parseResponse(
            $this->client->request('POST', '/email/batch', [
                RequestOptions::BODY => $batch->toJson(),
            ]),
            SendBatchResponse::class
        );
    }

    /**
     * Send an email using a template created previously.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendWithTemplate(EmailWithTemplate $emailWithTemplate): ApiResponse
    {
        return $this->parseResponse(
            $this->client->request('POST', '/email/withTemplate', [
                RequestOptions::BODY => $emailWithTemplate->toJson(),
            ]),
            SendWithTemplateResponse::class
        );
    }

    /**
     * Send a batch of emails using a template created previously.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendBatchWithTemplate(BatchWithTemplate $batchWithTemplate): ApiResponse
    {
        return $this->parseResponse(
            $this->client->request('POST', '/email/batchWithTemplates', [
                RequestOptions::BODY => $batchWithTemplate->toJson(),
            ]),
            SendBatchWithTemplateResponse::class
        );
    }

    /**
     * Hydrate the given response interface or throw an exception.
     *
     * @param  \Psr\Http\Message\ResponseInterface  $response
     * @param  class-string  $hydratorClass
     * @return \Ixdf\Postmark\Contracts\ApiResponse
     */
    private function parseResponse(ResponseInterface $response, string $hydratorClass): ApiResponse
    {
        return match ($response->getStatusCode()) {
            200 => $this->hydrator->hydrate($response, $hydratorClass),
            401 => throw new IncorrectApiTokenException($response->getBody()->getContents()),
            500 => throw new ServerErrorException($response->getBody()->getContents()),
            503 => throw new PostmarkUnavailable($response->getBody()->getContents()),
            default => throw new UnknownException($response->getBody()->getContents())
        };
    }
}
