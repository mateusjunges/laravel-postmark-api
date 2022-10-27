<?php

namespace InteractionDesignFoundation\Postmark\Contracts;

use InteractionDesignFoundation\Postmark\Api\Message\Requests\Batch;
use InteractionDesignFoundation\Postmark\Api\Message\Requests\BatchWithTemplate;
use InteractionDesignFoundation\Postmark\Api\Message\Requests\EmailWithTemplate;
use InteractionDesignFoundation\Postmark\Api\Message\Requests\Message;

interface MessageApi
{
    public function send(Message $message): ApiResponse;

    public function sendBatch(Batch $batch): ApiResponse;

    public function sendWithTemplate(EmailWithTemplate $emailWithTemplate): ApiResponse;

    public function sendBatchWithTemplate(BatchWithTemplate $batchWithTemplate): ApiResponse;
}
