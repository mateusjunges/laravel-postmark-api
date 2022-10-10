<?php declare(strict_types=1);

namespace Ixdf\Postmark\Models\Message;

use Ixdf\Postmark\Contracts\ApiResponse;

final class SendBatchWithTemplateResponse implements ApiResponse
{
    private array $responses = [];

    public static function create(array $data): self
    {
        $model = new self();

        foreach ($data as $response) {
            $model->responses[] = SendWithTemplateResponse::create($response);
        }

        return $model;
    }

    public function getResponse(): array
    {
        return $this->responses;
    }
}
