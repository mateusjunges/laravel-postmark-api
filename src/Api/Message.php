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
use Ixdf\Postmark\Models\Message\BatchCollection;
use Ixdf\Postmark\Models\Message\Response\SendBatchEmailResponse;
use Ixdf\Postmark\Models\Message\Response\SendWithTemplateResponse;
use Ixdf\Postmark\Models\Message\SendWithTemplate;

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
    public function sendBatch(BatchCollection $request)
    {
        $response = $this->client->request('POST', '/email/batch', [
            RequestOptions::BODY => $request->toJson(),
        ]);

        return match ($response->getStatusCode()) {
            200 => $this->hydrator->hydrate($response, SendBatchEmailResponse::class),
            401 => throw new IncorrectApiTokenException($response->getBody()->getContents()),
            500 => throw new ServerErrorException($response->getBody()->getContents()),
            503 => throw new PostmarkUnavailable($response->getBody()->getContents()),
            default => throw new UnknownException($response->getBody()->getContents())
        };
    }

    public function sendWithTemplate(SendWithTemplate $request): ApiResponse
    {
        $response = $this->client->request('POST', '/email/withTemplate', [
            RequestOptions::BODY => $request->toJson(),
        ]);

        return match ($response->getStatusCode()) {
            200 => $this->hydrator->hydrate($response, SendWithTemplateResponse::class),
            401 => throw new IncorrectApiTokenException($response->getBody()->getContents()),
            500 => throw new ServerErrorException($response->getBody()->getContents()),
            503 => throw new PostmarkUnavailable($response->getBody()->getContents()),
            default => throw new UnknownException($response->getBody()->getContents())
        };
    }
}
