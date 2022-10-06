<?php declare(strict_types=1);

namespace Ixdf\Postmark\Models\Message;

use Ixdf\Postmark\Enums\TrackLinksEnum;

final class BatchMessage
{
    private string $from; // required
    private string $to; // required
    private string $subject; // required
    private string $htmlBody = ""; // required when textBody is empty
    private string $textBody = ""; // required when htmlBody is empty
    private array $cc = []; // optional
    private array $bcc = []; // optional
    private array $metadata = []; // optional
    private string $tag = ""; // optional
    private string $replyTo = ""; // optional
    private array $headers = []; // optional
    private bool $trackOpens = true; // optional
    private ?TrackLinksEnum $trackLinks = null; // optional
    private string $messageStream = 'broadcast'; // required
    private array $attachments = []; // optional

    public function setFromAddress(string $from, array $variables = []): BatchMessage
    {
        if (isset($variables['full_name'])) {
            $this->from = $variables['full_name'] . " <$from>";
        } else {
            $this->from = "$from <$from>";
        }

        return $this;
    }

    public function setToAddress(string $to): BatchMessage
    {
        $this->to = $to;
        return $this;
    }

    public function setSubject(string $subject): BatchMessage
    {
        $this->subject = $subject;
        return $this;
    }

    public function setHtmlBody(string $htmlBody): BatchMessage
    {
        $this->htmlBody = $htmlBody;
        return $this;
    }

    public function setTextBody(string $textBody): BatchMessage
    {
        $this->textBody = $textBody;
        return $this;
    }

    public function setCc(array $cc): BatchMessage
    {
        $this->cc = $cc;
        return $this;
    }

    public function setBcc(array $bcc): BatchMessage
    {
        $this->bcc = $bcc;
        return $this;
    }

    public function setMetadata(array $metadata): BatchMessage
    {
        $this->metadata = $metadata;
        return $this;
    }

    public function addTag(string $tag): BatchMessage
    {
        $this->tag = $tag;

        return $this;
    }

    public function setReplyTo(string $replyTo): BatchMessage
    {
        $this->replyTo = $replyTo;
        return $this;
    }

    public function setHeaders(array $headers): BatchMessage
    {
        $this->headers = $headers;
        return $this;
    }

    public function setOpenTracking(bool $trackOpens): BatchMessage
    {
        $this->trackOpens = $trackOpens;
        return $this;
    }

    public function setTrackLinks(TrackLinksEnum $trackLinks): BatchMessage
    {
        $this->trackLinks = $trackLinks;
        return $this;
    }

    public function setMessageStream(string $messageStream): BatchMessage
    {
        $this->messageStream = $messageStream;
        return $this;
    }

    public function addAttachment(Attachment $attachment): BatchMessage
    {
        $this->attachments[] = $attachment->toArray();
        return $this;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
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

    public function isTrackingOpens(): bool
    {
        return $this->trackOpens;
    }

    public function getTrackLinks(): TrackLinksEnum
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

    private function prepareHeaders(): array
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

    public function toArray(): array
    {
        $array = [
            'From' => $this->from,
            'To' => $this->to,
            'Cc' => implode(',', $this->cc),
            'Bcc' => implode(',', $this->bcc),
            'Subject' => $this->subject,
            'HtmlBody' => $this->htmlBody,
            'TextBody' => $this->textBody,
            'Tag' => $this->tag,
            'ReplyTo' => $this->replyTo,
            'Headers' => $this->prepareHeaders(),
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
}
