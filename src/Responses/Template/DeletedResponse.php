<?php

namespace Ixdf\Postmark\Responses\Template;

use Illuminate\Contracts\Support\Arrayable;
use Ixdf\Postmark\Contracts\ApiResponse;

final class DeletedResponse implements ApiResponse, Arrayable
{
    private string $message;
    private int $errorCode = 0;

    public static function create(array $data): self
    {
        $model = new self();
        $model->message = $data['Message'];
        $model->errorCode = $data['ErrorCode'];

        return $model;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    public function toArray(): array
    {
        return [
            'ErrorCode' => $this->errorCode,
            'Message' => $this->message,
        ];
    }
}
