<?php declare(strict_types=1);

namespace Ixdf\Postmark\Api\Message\Requests;

use Ixdf\Postmark\Enums\TrackLinksEnum;

final class Message
{
    private string $from;
    private array $to = [];
    private string $subject;
    private string $htmlBody = "";
    private string $textBody = "";
    private array $cc = [];
    private array $bcc = [];
    private array $metadata = [];
    private string $tag = "";
    private string $replyTo = "";
    private array $headers = [];
    private bool $trackOpens = true;
    private ?TrackLinksEnum $trackLinks = null;
    private string $messageStream = 'broadcast';
    private array $attachments = [];

    public function setFromAddress(string $from, array $options = []): Message
    {
        if (isset($options['full_name'])) {
            $this->from = $options['full_name'] . " <$from>";
        } else {
            $this->from = "$from <$from>";
        }

        return $this;
    }

    public function addToAddress(string $to): Message
    {
        $this->to = array_merge($this->to, [$to]);

        return $this;
    }

    public function setSubject(string $subject): Message
    {
        $this->subject = $subject;
        return $this;
    }

    public function setHtmlBody(string $htmlBody): Message
    {
        $this->htmlBody = $htmlBody;
        return $this;
    }

    public function setTextBody(string $textBody): Message
    {
        $this->textBody = $textBody;
        return $this;
    }

    public function addCC(array $cc): Message
    {
        $this->cc = array_merge($this->cc, [$cc]);

        return $this;
    }

    public function addBcc(array $bcc): Message
    {
        $this->bcc = array_merge($this->bcc, [$bcc]);

        return $this;
    }

    public function setMetadata(string $key, mixed $metadata): Message
    {
        $this->metadata[$key] = $metadata;
        return $this;
    }

    public function addTag(string $tag): Message
    {
        $this->tag = $tag;

        return $this;
    }

    public function setReplyTo(string $replyTo): Message
    {
        $this->replyTo = $replyTo;
        return $this;
    }

    public function setHeaders(array $headers): Message
    {
        $this->headers = $headers;
        return $this;
    }

    public function setOpenTracking(bool $trackOpens): Message
    {
        $this->trackOpens = $trackOpens;
        return $this;
    }

    public function setTrackLinks(TrackLinksEnum $trackLinks): Message
    {
        $this->trackLinks = $trackLinks;
        return $this;
    }

    public function setMessageStream(string $messageStream): Message
    {
        $this->messageStream = $messageStream;
        return $this;
    }

    public function addAttachment(Attachment $attachment): Message
    {
        $this->attachments[] = $attachment->toArray();
        return $this;
    }

    private function getPreparedHeaders(): array
    {
        $response = [];

        if (! empty($this->headers)) {
            foreach ($this->headers as $key => $value) {
                $response[] = [
                    'Name' => $key,
                    'Value' => $value
                ];
            }
        }

        return $response;
    }

    public function getToAddress(): string
    {
        return implode(',', $this->to);
    }

    public function getFrom(): string
    {
        return $this->from;
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

    public function getCc(): array
    {
        return $this->cc;
    }

    public function getBcc(): array
    {
        return $this->bcc;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
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

    public function getTrackLinks(): ?TrackLinksEnum
    {
        return $this->trackLinks;
    }

    public function getMessageStream(): string
    {
        return $this->messageStream;
    }

    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function toArray(): array
    {
        $array = [
            'From' => $this->from,
            'To' => implode(',', $this->to),
            'Cc' => implode(',', $this->cc),
            'Bcc' => implode(',', $this->bcc),
            'Subject' => $this->subject,
            'HtmlBody' => $this->htmlBody,
            'TextBody' => $this->textBody,
            'Tag' => $this->tag,
            'ReplyTo' => $this->replyTo,
            'Headers' => $this->getPreparedHeaders(),
            'TrackOpens' => $this->trackOpens,
            'Attachments' => $this->attachments,
            'Metadata' => $this->metadata,
            'MessageStream' => $this->messageStream,
        ];

        if ($this->trackLinks !== null) {
            $array['TrackLinks'] = $this->trackLinks->value;
        }

        return collect($array)->reject(fn ($item) => empty($item))->all();
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
