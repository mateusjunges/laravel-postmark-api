<?php declare(strict_types=1);

namespace Ixdf\Postmark\Api\Message;

use GuzzleHttp\RequestOptions;
use Ixdf\Postmark\Api\Api;
use Ixdf\Postmark\Api\Message\Requests\Batch;
use Ixdf\Postmark\Api\Message\Requests\BatchWithTemplate;
use Ixdf\Postmark\Api\Message\Requests\EmailWithTemplate;
use Ixdf\Postmark\Api\Message\Requests\Message as MessageRequest;
use Ixdf\Postmark\Contracts\ApiResponse;
use Ixdf\Postmark\Contracts\MessageApi;
use Ixdf\Postmark\Models\Message\SendResponse;
use Ixdf\Postmark\Models\Message\SendBatchResponse;
use Ixdf\Postmark\Models\Message\SendBatchWithTemplateResponse;
use Ixdf\Postmark\Models\Message\SendWithTemplateResponse;

final class Message extends Api implements MessageApi
{
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
}
