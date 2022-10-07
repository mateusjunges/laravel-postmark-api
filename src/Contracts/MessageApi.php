<?php

namespace Ixdf\Postmark\Contracts;

use Ixdf\Postmark\Models\Message\Batch;
use Ixdf\Postmark\Models\Message\BatchWithTemplate;
use Ixdf\Postmark\Models\Message\EmailWithTemplate;
use Ixdf\Postmark\Models\Message\Message;

interface MessageApi
{
    public function send(Message $message): ApiResponse;

    public function sendBatch(Batch $batch): ApiResponse;

    public function sendWithTemplate(EmailWithTemplate $emailWithTemplate): ApiResponse;

    public function sendBatchWithTemplate(BatchWithTemplate $batchWithTemplate): ApiResponse;
}
