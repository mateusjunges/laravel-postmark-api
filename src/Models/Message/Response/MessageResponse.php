<?php declare(strict_types=1);

namespace Ixdf\Postmark\Models\Message\Response;

use Ixdf\Postmark\Contracts\ApiResponse;

final class MessageResponse implements ApiResponse
{
    private int $errorCode = 0;
    private string $message;
    private string $messageId;
    private string $submittedAt;
    private string $to;

    public static function create(array $data): self
    {
        $model = new self();
        $model->errorCode = (int) $data['ErrorCode'] ?? 0;
        $model->message = $data['Message'] ?? '';
        $model->messageId = $data['MessageID'] ?? '';
        $model->submittedAt = $data['SubmittedAt'] ?? '';
        $model->to = $data['To'] ?? '';

        return $model;
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getMessageId(): string
    {
        return $this->messageId;
    }

    public function getSubmittedAt(): string
    {
        return $this->submittedAt;
    }

    public function getTo(): string
    {
        return $this->to;
    }
}
