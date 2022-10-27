<?php declare(strict_types=1);

namespace Ixdf\Postmark\Responses;

use Ixdf\Postmark\Contracts\ApiResponse;

final class ErrorResponse implements ApiResponse
{
    private int $errorCode = 0;
    private string $message;

    public static function create(array $data): self
    {
        $response = new self();
        $response->message = $data['Message'];
        $response->errorCode = $data['ErrorCode'];

        return $response;
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
