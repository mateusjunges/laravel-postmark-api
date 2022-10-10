<?php

namespace Ixdf\Postmark\Models\Template;

use Ixdf\Postmark\Contracts\ApiResponse;

final class ShowResponse implements ApiResponse
{
    private string $name;
    private int $templateId;
    private string $subject;
    private ?string $htmlBody = null;
    private ?string $textBody = null;
    private int $associatedServerId;
    private bool $active;
    private string $alias;
    private ?string $templateType;
    private ?string $layoutTemplate;

    public static function create(array $data): self
    {
        $model = new self();
        $model->name = $data['Name'];
        $model->templateId = $data['TemplateId'];
        $model->subject = $data['Subject'];
        $model->htmlBody = $data['HtmlBody'];
        $model->textBody = $data['TextBody'];
        $model->associatedServerId = $data['AssociatedServerId'];
        $model->active = (bool) $data['Active'];
        $model->alias = $data['Alias'];
        $model->templateType = $data['TemplateType'];
        $model->layoutTemplate = $data['LayoutTemplate'];

        return $model;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTemplateId(): int
    {
        return $this->templateId;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getHtmlBody(): string
    {
        return $this->htmlBody;
    }

    public function getTextBody(): string
    {
        return $this->textBody;
    }

    public function getAssociatedServerId(): int
    {
        return $this->associatedServerId;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function getTemplateType(): ?string
    {
        return $this->templateType;
    }

    public function getLayoutTemplate(): ?string
    {
        return $this->layoutTemplate;
    }
}
