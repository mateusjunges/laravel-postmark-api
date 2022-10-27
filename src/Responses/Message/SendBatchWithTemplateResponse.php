<?php declare(strict_types=1);

namespace Ixdf\Postmark\Responses\Message;

use Ixdf\Postmark\Contracts\ApiResponse;
use Ixdf\Postmark\Responses\ErrorResponse;

final class SendBatchWithTemplateResponse implements ApiResponse
{
    private array $responses = [];

    public static function create(array $data): self
    {
        $model = new self();

        foreach ($data as $response) {
            if ($response['ErrorCode'] !== 0) {
                $model->responses[] = ErrorResponse::create($response);
            } else {
                $model->responses[] = SendWithTemplateResponse::create($response);
            }

        }

        return $model;
    }

    public function getResponse(): array
    {
        return $this->responses;
    }
}
