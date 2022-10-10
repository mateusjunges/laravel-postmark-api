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
use Ixdf\Postmark\Models\Message\ErrorResponse;
use Ixdf\Postmark\Models\Message\SendResponse;
use Ixdf\Postmark\Models\Message\SendBatchResponse;
use Ixdf\Postmark\Models\Message\SendBatchWithTemplateResponse;
use Ixdf\Postmark\Models\Message\SendWithTemplateResponse;

final class Message extends Api implements MessageApi
{
    /**
     * Send a given message.
     */
    public function send(MessageRequest $message): ApiResponse
    {
        return $this->request('POST', '/email', SendResponse::class, [
            RequestOptions::BODY => $message->toJson()
        ]);
    }

    /**
     * Send a batch of emails.
     *
     * @throws \Ixdf\Postmark\Exceptions\IncorrectApiTokenException
     * @throws \Ixdf\Postmark\Exceptions\ServerErrorException
     * @throws \Ixdf\Postmark\Exceptions\PostmarkUnavailable
     * @throws \Ixdf\Postmark\Exceptions\UnknownException
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
