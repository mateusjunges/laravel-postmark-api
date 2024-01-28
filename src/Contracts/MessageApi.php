<?php

namespace Junges\Postmark\Contracts;

use Junges\Postmark\Api\Message\Requests\Batch;
use Junges\Postmark\Api\Message\Requests\BatchWithTemplate;
use Junges\Postmark\Api\Message\Requests\EmailWithTemplate;
use Junges\Postmark\Api\Message\Requests\Message;

interface MessageApi
{
    public function send(Message $message): ApiResponse;

    public function sendBatch(Batch $batch): ApiResponse;

    public function sendWithTemplate(EmailWithTemplate $emailWithTemplate): ApiResponse;

    public function sendBatchWithTemplate(BatchWithTemplate $batchWithTemplate): ApiResponse;
}
