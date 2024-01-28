<?php declare(strict_types=1);

namespace Junges\Postmark\Api\Template\Requests;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

final class TemplateModel implements Arrayable, Jsonable
{
    private array $model = [];

    public static function make(): self
    {
        return new self();
    }

    public function add(string $key, mixed $value): self
    {
        $this->model[$key] = $value;

        return $this;
    }

    public function toArray(): array
    {
        return $this->model;
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->model);
    }

    public function __toString(): string
    {
        return $this->toJson();
    }
}
