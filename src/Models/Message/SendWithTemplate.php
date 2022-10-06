<?php declare(strict_types=1);

namespace Ixdf\Postmark\Models\Message;

use Ixdf\Postmark\Enums\TrackLinksEnum;
use Ixdf\Postmark\Models\Template\TemplateModel;

final class SendWithTemplate
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

    public function setFromAddress(string $from, array $attributes = []): SendWithTemplate
    {
        $fullName = $from;

        if (isset($attributes['full_name'])) {
            $fullName = $attributes['full_name'];
        }

        $this->from = "$fullName <$from>";

        return $this;
    }

    public function setTemplateId(?int $templateId): SendWithTemplate
    {
        $this->templateId = $templateId;
        return $this;
    }

    public function setTemplateAlias(?string $templateAlias): SendWithTemplate
    {
        $this->templateAlias = $templateAlias;
        return $this;
    }

    public function setTemplateModel(TemplateModel $model): SendWithTemplate
    {
        $this->model = $model;
        return $this;
    }

    public function setInlineCss(bool $inlineCss): SendWithTemplate
    {
        $this->inlineCss = $inlineCss;
        return $this;
    }

    public function addToAddress(string $to): SendWithTemplate
    {
        $this->to[] = $to;

        return $this;
    }

    public function addCcAddress(string $cc): SendWithTemplate
    {
        $this->cc[] = $cc;
        return $this;
    }

    public function addBccAddress(string $bcc): SendWithTemplate
    {
        $this->bcc[] = $bcc;
        return $this;
    }

    public function setTag(string $tag): SendWithTemplate
    {
        $this->tag = $tag;
        return $this;
    }

    public function setReplyTo(string $replyTo): SendWithTemplate
    {
        $this->replyTo = $replyTo;
        return $this;
    }

    public function setHeaders(array $headers): SendWithTemplate
    {
        $this->headers = $headers;
        return $this;
    }

    public function setTrackOpens(bool $trackOpens): SendWithTemplate
    {
        $this->trackOpens = $trackOpens;
        return $this;
    }

    public function setTrackLinks(TrackLinksEnum $trackLinks): SendWithTemplate
    {
        $this->trackLinks = $trackLinks;
        return $this;
    }

    public function addAttachment(Attachment $attachment): SendWithTemplate
    {
        $this->attachments[] = $attachment->toArray();

        return $this;
    }

    public function addMetadata(string $key, string | int | float $value): SendWithTemplate
    {
        $this->metadata[$key] = $value;
        return $this;
    }

    public function setMessageStream(string $messageStream): SendWithTemplate
    {
        $this->messageStream = $messageStream;
        return $this;
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
}
