<?php declare(strict_types=1);

namespace Ixdf\Postmark\Models\Message;

use Ixdf\Postmark\Contracts\ApiResponse;

final class SendBatchResponse implements ApiResponse
{
    private array $messages = [];

    public static function create(array $data): self
    {
        $model = new self();

        foreach ($data as $message) {
            $model->messages[] = SendResponse::create($message);
        }

        return $model;
    }

    public function getResponse(): array
    {
        return $this->messages;
    }
}
