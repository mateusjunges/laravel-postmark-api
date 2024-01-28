<?php declare(strict_types=1);

namespace Junges\Postmark\Support\Testing\Fakes;

use Closure;
use Junges\Postmark\Api\Message\Requests\Batch;
use Junges\Postmark\Api\Message\Requests\BatchWithTemplate;
use Junges\Postmark\Api\Message\Requests\EmailWithTemplate;
use Junges\Postmark\Api\Message\Requests\Message;
use Junges\Postmark\Contracts\ApiResponse;
use Junges\Postmark\Contracts\MessageApi;

final class MessagesApiFake implements MessageApi
{
    private Closure $sendSingleMessageCallback;
    private Closure $sendBatchesCallback;
    private Closure $sendTemplatesCallback;
    private Closure $sendBatchTemplatesCallback;

    public function send(Message $message): ApiResponse
    {
        call_user_func($this->sendSingleMessageCallback, $message);

        return ApiResponseFake::create([]);
    }

    public function sendBatch(Batch $batch): ApiResponse
    {
        call_user_func($this->sendBatchesCallback, $batch);

        return ApiResponseFake::create([]);
    }

    public function sendWithTemplate(EmailWithTemplate $emailWithTemplate): ApiResponse
    {
        call_user_func($this->sendTemplatesCallback, $emailWithTemplate);

        return ApiResponseFake::create([]);
    }

    public function sendBatchWithTemplate(BatchWithTemplate $batchWithTemplate): ApiResponse
    {
        call_user_func($this->sendBatchTemplatesCallback, $batchWithTemplate);

        return ApiResponseFake::create([]);
    }

    public function sendSingleMessageUsing(Closure $callback): self
    {
        $this->sendSingleMessageCallback = $callback;

        return $this;
    }

    public function sendBatchesUsing(Closure $callback): self
    {
        $this->sendBatchesCallback = $callback;

        return $this;
    }

    public function sendTemplatesUsing(Closure $callback): self
    {
        $this->sendTemplatesCallback = $callback;

        return $this;
    }

    public function sendBatchTemplatesUsing(Closure $callback): self
    {
        $this->sendBatchTemplatesCallback = $callback;

        return $this;
    }
}
