<?php declare(strict_types=1);

namespace InteractionDesignFoundation\Postmark\Responses\Message;

use InteractionDesignFoundation\Postmark\Contracts\ApiResponse;
use InteractionDesignFoundation\Postmark\Responses\ErrorResponse;

final class SendBatchResponse implements ApiResponse
{
    private array $messages = [];

    public static function create(array $data): self
    {
        $model = new self();

        foreach ($data as $message) {
            if ($message['ErrorCode'] !== 0) {
                $model->messages[] = ErrorResponse::create($message);
            } else {
                $model->messages[] = SendResponse::create($message);
            }
        }

        return $model;
    }

    public function getResponse(): array
    {
        return $this->messages;
    }
}
