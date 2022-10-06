<?php

namespace Ixdf\Postmark\Models\Template;

final class TemplateModel
{
    private string $name;
    private string $alias = "";
    private string $htmlBody = "";
    private string $htmlBodyAfterReplacements = "";
    private string $textBody = "";
    private string $textBodyAfterReplacements = "";
    private string $subject;
    private string $templateType = "";
    private string $layoutTemplate = "";
    private array $replacements = [];

    public function setName(string $name): TemplateModel
    {
        $this->name = $name;
        return $this;
    }

    public function setAlias(string $alias): TemplateModel
    {
        $this->alias = $alias;
        return $this;
    }

    public function addReplacement(string $search, string $replaceWith): TemplateModel
    {
        $this->replacements[$search] = $replaceWith;

        return $this;
    }

    public function setHtmlBody(string $htmlBody): TemplateModel
    {
        $this->htmlBody = $htmlBody;

        return $this;
    }

    public function setTextBody(string $textBody): TemplateModel
    {
        $this->textBody = $textBody;

        return $this;
    }

    public function setSubject(string $subject): TemplateModel
    {
        $this->subject = $subject;
        return $this;
    }

    public function setTemplateType(string $templateType): TemplateModel
    {
        $this->templateType = $templateType;
        return $this;
    }

    public function setLayoutTemplate(string $layoutTemplate): TemplateModel
    {
        $this->layoutTemplate = $layoutTemplate;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function getHtmlBody(): string
    {
        return $this->htmlBody;
    }

    public function getHtmlBodyWithPostmarkPlaceholders(): string
    {
        return $this->htmlBodyAfterReplacements;
    }

    public function getTextBody(): string
    {
        return $this->textBody;
    }

    public function getTextBodyWithPostmarkPlaceholders(): string
    {
        return $this->textBodyAfterReplacements;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getTemplateType(): string
    {
        return $this->templateType;
    }

    public function getLayoutTemplate(): string
    {
        return $this->layoutTemplate;
    }

    public function toArray(): array
    {
        return collect([
            'Name' => $this->name,
            'Alias' => $this->alias,
            'Subject' => $this->name,
            'TextBody' => $this->replacePostmarkPlaceholders($this->textBody),
            'HtmlBody' => $this->replacePostmarkPlaceholders($this->htmlBody),
            'TemplateType' => $this->templateType,
            'LayoutTemplate' => $this->layoutTemplate
        ])->reject(fn (string $value): bool => empty($value))->all();
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    private function replacePostmarkPlaceholders(string $content): string
    {
        return str_replace(
            array_keys($this->replacements),
            array_values($this->replacements),
            $content,
        );
    }
}
