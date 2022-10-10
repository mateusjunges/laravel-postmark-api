<?php declare(strict_types=1);

namespace Ixdf\Postmark\Support\Testing\Fakes;

use Closure;
use Ixdf\Postmark\Contracts\ApiResponse;
use Ixdf\Postmark\Contracts\MessageApi;
use Ixdf\Postmark\Models\Message\Batch;
use Ixdf\Postmark\Models\Message\BatchWithTemplate;
use Ixdf\Postmark\Models\Message\EmailWithTemplate;
use Ixdf\Postmark\Models\Message\Message;

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
