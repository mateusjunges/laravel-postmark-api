<?php declare(strict_types=1);

namespace InteractionDesignFoundation\Postmark\Api\Message\Requests;

use InteractionDesignFoundation\Postmark\Api\Template\Requests\TemplateModel;
use InteractionDesignFoundation\Postmark\Enums\TrackLinksEnum;

final class EmailWithTemplate
{
    private string $from;
    private ?int $templateId = null;
    private ?string $templateAlias = null;
    private TemplateModel $model;
    private bool $inlineCss = false;
    private array $to = [];
    private array $cc = [];
    private array $bcc = [];
    private string $tag = "";
    private string $replyTo = "";
    private array $headers = [];
    private bool $trackOpens = true;
    private TrackLinksEnum $trackLinks = TrackLinksEnum::NONE;
    private array $attachments = [];
    private array $metadata = [];
    private string $messageStream = "outbound";

    public function setFromAddress(Address $from): EmailWithTemplate
    {
        $this->from = "$from->fullName() <$from->emailAddress>";

        return $this;
    }

    public function setTemplateId(int $templateId): EmailWithTemplate
    {
        $this->templateId = $templateId;
        return $this;
    }

    public function setTemplateAlias(string $templateAlias): EmailWithTemplate
    {
        $this->templateAlias = $templateAlias;
        return $this;
    }

    public function setTemplateModel(TemplateModel $model): EmailWithTemplate
    {
        $this->model = $model;
        return $this;
    }

    public function setInlineCss(bool $inlineCss): EmailWithTemplate
    {
        $this->inlineCss = $inlineCss;
        return $this;
    }

    public function addToAddress(Address $to): EmailWithTemplate
    {
        $this->to = array_merge($this->to, ["{$to->fullName()} <$to->emailAddress>"]);

        return $this;
    }

    public function addCcAddress(Address $cc): EmailWithTemplate
    {
        $this->cc = array_merge($this->to, ["{$cc->fullName()} <$cc->emailAddress>"]);

        return $this;
    }

    public function addBccAddress(Address $bcc): EmailWithTemplate
    {
        $this->bcc = array_merge($this->bcc, ["{$bcc->fullName()} <$bcc->emailAddress>"]);

        return $this;
    }

    public function addTag(string $tag): EmailWithTemplate
    {
        $this->tag = $tag;

        return $this;
    }

    public function setReplyTo(Address $replyTo): EmailWithTemplate
    {
        $this->replyTo = "{$replyTo->fullName()} <$replyTo->emailAddress>";
        return $this;
    }

    public function setHeaders(array $headers): EmailWithTemplate
    {
        $this->headers = $headers;
        return $this;
    }

    public function setOpenTracking(bool $trackOpens): EmailWithTemplate
    {
        $this->trackOpens = $trackOpens;
        return $this;
    }

    public function setTrackLinks(TrackLinksEnum $trackLinks): EmailWithTemplate
    {
        $this->trackLinks = $trackLinks;
        return $this;
    }

    public function addAttachment(Attachment $attachment): EmailWithTemplate
    {
        $this->attachments[] = $attachment->toArray();

        return $this;
    }

    public function addMetadata(string $key, string | int | float $value): EmailWithTemplate
    {
        $this->metadata[$key] = $value;

        return $this;
    }

    public function setMessageStream(string $messageStream): EmailWithTemplate
    {
        $this->messageStream = $messageStream;
        return $this;
    }

    public function shouldSetTemplateIdOrAlias(): bool
    {
        return $this->templateAlias === null && $this->templateId === null;
    }

    public function toArray(): array
    {
        return collect([
            'TemplateId' => $this->templateId,
            'TemplateAlias' => $this->templateAlias,
            'TemplateModel' => $this->model->toArray(),
            'InlineCss' => $this->inlineCss,
            'From' => $this->from,
            'To' => implode(",", $this->to),
            'Cc' => implode(",", $this->cc),
            'Bcc' => implode(",", $this->bcc),
            'Tag' => $this->tag,
            'ReplyTo' => $this->replyTo,
            'Headers' => $this->headers,
            'TrackOpens' => $this->trackOpens,
            'TrackLinks' => $this->trackLinks->value,
            'Attachments' => $this->attachments,
            'Metadata' => $this->metadata,
            'MessageStream' => $this->messageStream
        ])->reject(fn ($value): bool => empty($value))->all();
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTemplateId(): ?int
    {
        return $this->templateId;
    }

    public function getTemplateAlias(): ?string
    {
        return $this->templateAlias;
    }

    public function getModel(): TemplateModel
    {
        return $this->model;
    }

    public function isInlineCss(): bool
    {
        return $this->inlineCss;
    }

    public function getTo(): array
    {
        return $this->to;
    }

    public function getCc(): array
    {
        return $this->cc;
    }

    public function getBcc(): array
    {
        return $this->bcc;
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function getReplyTo(): string
    {
        return $this->replyTo;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function isTrackOpens(): bool
    {
        return $this->trackOpens;
    }

    public function getTrackLinks(): TrackLinksEnum
    {
        return $this->trackLinks;
    }

    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function getMessageStream(): string
    {
        return $this->messageStream;
    }
}
