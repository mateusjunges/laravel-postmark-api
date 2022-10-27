<?php declare(strict_types=1);

namespace InteractionDesignFoundation\Postmark\Responses\Template;

use InteractionDesignFoundation\Postmark\Contracts\ApiResponse;

final class CreateResponse implements ApiResponse
{
    private int $templateId;
    private string $name;
    private bool $active;
    private string $alias = "";
    private ?string $templateType;
    private ?string $layoutTemplate;

    public static function create(array $data): self
    {
        $model = new self();
        $model->templateId = $data['TemplateId'];
        $model->name = $data['Name'];
        $model->alias = $data['Alias'];
        $model->active = (bool) $data['Active'];
        $model->templateType = $data['TemplateType'];
        $model->layoutTemplate = $data['LayoutTemplate'];

        return $model;
    }

    public function toArray(): array
    {
        return [
            'TemplateId' => $this->templateId,
            'Name' => $this->name,
            'Active' => $this->active,
            'Alias' => $this->alias,
            'TemplateType' => $this->templateType,
            'LayoutTemplate' => $this->layoutTemplate
        ];
    }

    public function getTemplateId(): int
    {
        return $this->templateId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function getTemplateType(): string
    {
        return $this->templateType;
    }

    public function getLayoutTemplate(): string
    {
        return $this->layoutTemplate;
    }
}
