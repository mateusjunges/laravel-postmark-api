<?php declare(strict_types=1);

namespace InteractionDesignFoundation\Postmark\Api\Message;

use GuzzleHttp\RequestOptions;
use InteractionDesignFoundation\Postmark\Api\Api;
use InteractionDesignFoundation\Postmark\Api\Message\Requests\Batch;
use InteractionDesignFoundation\Postmark\Api\Message\Requests\BatchWithTemplate;
use InteractionDesignFoundation\Postmark\Api\Message\Requests\EmailWithTemplate;
use InteractionDesignFoundation\Postmark\Api\Message\Requests\Message as MessageRequest;
use InteractionDesignFoundation\Postmark\Contracts\ApiResponse;
use InteractionDesignFoundation\Postmark\Contracts\MessageApi;
use InteractionDesignFoundation\Postmark\Responses\Message\SendResponse;
use InteractionDesignFoundation\Postmark\Responses\Message\SendBatchResponse;
use InteractionDesignFoundation\Postmark\Responses\Message\SendBatchWithTemplateResponse;
use InteractionDesignFoundation\Postmark\Responses\Message\SendWithTemplateResponse;

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
     * @throws \InteractionDesignFoundation\Postmark\Exceptions\IncorrectApiTokenException
     * @throws \InteractionDesignFoundation\Postmark\Exceptions\ServerErrorException
     * @throws \InteractionDesignFoundation\Postmark\Exceptions\PostmarkUnavailable
     * @throws \InteractionDesignFoundation\Postmark\Exceptions\UnknownException
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
