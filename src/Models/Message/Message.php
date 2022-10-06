<?php declare(strict_types=1);

namespace Ixdf\Postmark\Models\Message;

use Ixdf\Postmark\Enums\TrackLinksEnum;

final class Message
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

    public function setFromAddress(string $from, array $variables = []): Message
    {
        if (isset($variables['full_name'])) {
            $this->from = $variables['full_name'] . " <$from>";
        } else {
            $this->from = "$from <$from>";
        }

        return $this;
    }

    public function setToAddress(string $to): Message
    {
        $this->to = $to;
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

    public function setCc(array $cc): Message
    {
        $this->cc = $cc;
        return $this;
    }

    public function setBcc(array $bcc): Message
    {
        $this->bcc = $bcc;
        return $this;
    }

    public function setMetadata(array $metadata): Message
    {
        $this->metadata = $metadata;
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

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
