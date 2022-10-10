<?php

namespace Ixdf\Postmark\Contracts;

use Ixdf\Postmark\Api\Message\Requests\Batch;
use Ixdf\Postmark\Api\Message\Requests\BatchWithTemplate;
use Ixdf\Postmark\Api\Message\Requests\EmailWithTemplate;
use Ixdf\Postmark\Api\Message\Requests\Message;

interface MessageApi
{
    public function send(Message $message): ApiResponse;

    public function sendBatch(Batch $batch): ApiResponse;

    public function sendWithTemplate(EmailWithTemplate $emailWithTemplate): ApiResponse;

    public function sendBatchWithTemplate(BatchWithTemplate $batchWithTemplate): ApiResponse;
}
