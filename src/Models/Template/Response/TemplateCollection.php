<?php

namespace Ixdf\Postmark\Models\Template\Response;

use Ixdf\Postmark\Contracts\ApiResponse;

class TemplateCollection implements ApiResponse
{
    /** @var array<int, \Ixdf\Postmark\Models\Template\Response\TemplateResponse> $items */
    protected array $items = [];

    public static function create(array $data): self
    {
        $collection = new self();

        foreach ($data as $template) {
            $collection->push(TemplateResponse::create($template));
        }

        return $collection;
    }

    public function push(TemplateResponse $templateResponse): self
    {
        $this->items[] = $templateResponse;

        return $this;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}
