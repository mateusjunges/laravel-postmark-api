<?php

namespace Ixdf\Postmark\Models\Message;

use Ixdf\Postmark\Contracts\ApiResponse;

final class SendBatchEmailResponse implements ApiResponse
{
    private array $messages = [];

    public static function create(array $data): self
    {
        $model = new self();

        foreach ($data as $message) {
            $model->messages[] = BatchMessage::create($message);
        }

        return $model;
    }

    public function getResponse(): array
    {
        return $this->messages;
    }
}
