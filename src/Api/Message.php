<?php declare(strict_types=1);

namespace Ixdf\Postmark\Api;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use Ixdf\Postmark\Contracts\ApiResponse;
use Ixdf\Postmark\Contracts\Hydrator;
use Ixdf\Postmark\Exceptions\IncorrectApiTokenException;
use Ixdf\Postmark\Exceptions\PostmarkUnavailable;
use Ixdf\Postmark\Exceptions\ServerErrorException;
use Ixdf\Postmark\Exceptions\UnknownException;
use Ixdf\Postmark\Models\Message\Batch;
use Ixdf\Postmark\Models\Message\BatchWithTemplate;
use Ixdf\Postmark\Models\Message\Message as MessageRequest;
use Ixdf\Postmark\Models\Message\Response\MessageResponse;
use Ixdf\Postmark\Models\Message\Response\SendBatchEmailResponse;
use Ixdf\Postmark\Models\Message\Response\SendBatchWithTemplateResponse;
use Ixdf\Postmark\Models\Message\Response\SendWithTemplateResponse;
use Ixdf\Postmark\Models\Message\EmailWithTemplate;
use Psr\Http\Message\ResponseInterface;

final class Message
{
    public function __construct(
        private ClientInterface $client,
        private Hydrator $hydrator,
    ) {}

    public function send(MessageRequest $message): ApiResponse
    {
        return $this->parseResponse(
            $this->client->request('POST', '/email', [
                RequestOptions::BODY => $message->toJson()
            ]),
            MessageResponse::class
        );
    }

    /**
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
            SendBatchEmailResponse::class
        );
    }

    public function sendWithTemplate(EmailWithTemplate $emailWithTemplate): ApiResponse
    {
        return $this->parseResponse(
            $this->client->request('POST', '/email/withTemplate', [
                RequestOptions::BODY => $emailWithTemplate->toJson(),
            ]),
            SendWithTemplateResponse::class
        );
    }

    public function sendBatchWithTemplate(BatchWithTemplate $batchWithTemplate): ApiResponse
    {
        return $this->parseResponse(
            $this->client->request('POST', '/email/batchWithTemplates', [
                RequestOptions::BODY => $batchWithTemplate->toJson(),
            ]),
            SendBatchWithTemplateResponse::class
        );
    }

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
