<?php declare(strict_types=1);

namespace InteractionDesignFoundation\Postmark\Support\Testing\Fakes;

use InteractionDesignFoundation\Postmark\Contracts\ApiResponse;

final class ApiResponseFake implements ApiResponse
{
    private string $message;
    private int $errorCode;

    public static function create(array $data): ApiResponse
    {
        $model = new self();
        $model->message = 'OK';
        $model->errorCode = 0;

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
}
