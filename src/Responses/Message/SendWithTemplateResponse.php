<?php declare(strict_types=1);

namespace Junges\Postmark\Responses\Message;

use Junges\Postmark\Contracts\ApiResponse;

final class SendWithTemplateResponse implements ApiResponse
{
    private ?string $to = null;
    private ?string $submittedAt = null;
    private ?string $messageId = null;
    private int $errorCode = 0;
    private string $message;

    public static function create(array $data): self
    {
        $model = new self();
        $model->to = $data['To'];
        $model->submittedAt = $data['SubmittedAt'];
        $model->messageId = $data['MessageID'];
        $model->message = $data['Message'];
        $model->errorCode = $data['ErrorCode'];

        return $model;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getSubmittedAt(): string
    {
        return $this->submittedAt;
    }

    public function getMessageId(): string
    {
        return $this->messageId;
    }

    public function getErrorCode(): int
    {
        return $this->errorCode;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
