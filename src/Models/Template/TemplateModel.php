<?php declare(strict_types=1);

namespace Ixdf\Postmark\Models\Template;

final class TemplateModel
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

    public function toJson(): string
    {
        return json_encode($this->model);
    }

    public function __toString(): string
    {
        return $this->toJson();
    }
}
