<?php

namespace Ixdf\Postmark\Models\Template\Response;

use Illuminate\Support\Collection;
use Ixdf\Postmark\Contracts\ApiResponse;

class TemplateCollection extends Collection implements ApiResponse
{
    /** @var array<int, \Ixdf\Postmark\Models\Template\Response\TemplateResponse> $items */
    protected $items = [];

    public static function create(array $data): self
    {
        $collection = new self();

        foreach ($data as $template) {
            $collection->push(TemplateResponse::create($template));
        }

        return $collection;
    }
}
