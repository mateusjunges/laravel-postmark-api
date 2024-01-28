<?php declare(strict_types=1);

namespace Junges\Postmark\Api\Message;

use GuzzleHttp\RequestOptions;
use Junges\Postmark\Api\Api;
use Junges\Postmark\Api\Message\Requests\Batch;
use Junges\Postmark\Api\Message\Requests\BatchWithTemplate;
use Junges\Postmark\Api\Message\Requests\EmailWithTemplate;
use Junges\Postmark\Api\Message\Requests\Message as MessageRequest;
use Junges\Postmark\Contracts\ApiResponse;
use Junges\Postmark\Contracts\MessageApi;
use Junges\Postmark\Responses\Message\SendResponse;
use Junges\Postmark\Responses\Message\SendBatchResponse;
use Junges\Postmark\Responses\Message\SendBatchWithTemplateResponse;
use Junges\Postmark\Responses\Message\SendWithTemplateResponse;

final class Message extends Api implements MessageApi
{
    /** Send a given message.*/
    public function send(MessageRequest $message): ApiResponse
    {
        return $this->request('POST', '/email', SendResponse::class, [
            RequestOptions::BODY => $message->toJson()
        ]);
    }

    /**
     * Send a batch of emails.
     *
     * @throws \Junges\Postmark\Exceptions\IncorrectApiTokenException
     * @throws \Junges\Postmark\Exceptions\ServerErrorException
     * @throws \Junges\Postmark\Exceptions\PostmarkUnavailable
     * @throws \Junges\Postmark\Exceptions\UnknownException
     */
    public function sendBatch(Batch $batch): ApiResponse
    {
        return $this->request('POST', '/email/batch', SendBatchResponse::class, [
            RequestOptions::BODY => $batch->toJson(),
        ]);
    }

    /**
     * Send an email using a template created previously.
     */
    public function sendWithTemplate(EmailWithTemplate $emailWithTemplate): ApiResponse
    {
        return $this->request('POST', '/email/withTemplate', SendWithTemplateResponse::class, [
            RequestOptions::BODY => $emailWithTemplate->toJson(),
        ]);
    }

    /**
     * Send a batch of emails using a template created previously.
     */
    public function sendBatchWithTemplate(BatchWithTemplate $batchWithTemplate): ApiResponse
    {
        return $this->request('POST', '/email/batchWithTemplates', SendBatchWithTemplateResponse::class, [
            RequestOptions::BODY => $batchWithTemplate->toJson(),
        ]);
    }
}
