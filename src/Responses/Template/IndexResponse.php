<?php

namespace Junges\Postmark\Responses\Template;

use Illuminate\Contracts\Support\Arrayable;
use Junges\Postmark\Contracts\ApiResponse;

class IndexResponse implements ApiResponse, Arrayable
{
    /** @var array<int, \Junges\Postmark\Responses\Template\CreateResponse> $items */
    protected array $items = [];

    public static function create(array $data): self
    {
        $collection = new self();

        foreach ($data as $template) {
            $collection->push(CreateResponse::create($template));
        }

        return $collection;
    }

    public function push(CreateResponse $templateResponse): self
    {
        $this->items[] = $templateResponse;

        return $this;
    }

    public function toArray(): array
    {
        return $this->items;
    }
}
