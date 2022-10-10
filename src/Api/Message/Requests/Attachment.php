<?php declare(strict_types=1);

namespace Ixdf\Postmark\Api\Message\Requests;

use Illuminate\Contracts\Support\Arrayable;

final class Attachment implements Arrayable
{
    public function __construct(
        private readonly string $name,
        private readonly string $base64EncodedData,
        private readonly string $mimeType = 'application/octet-stream',
        private readonly ?string $contentId = null
    ) {}

    public static function fromRawData(string $data, string $attachmentName, string $mimeType = 'application/octet-stream', string $contentId = null): self
    {
        return new self(
            $attachmentName,
            $data,
            $mimeType,
            $contentId
        );
    }

    public static function fromBase64EncodedData(string $base64EncodedData, string $attachmentName, string $mimeType = 'application/octet-stream', string $contentId = null): self
    {
        return new self(
            $attachmentName,
            $base64EncodedData,
            $mimeType,
            $contentId
        );
    }

    public static function fromFile(string $filePath, string $attachmentName, string $mimeType = 'application/octet-stream', string $contentId = null): self
    {
        return new self(
            base64_encode(file_get_contents($filePath)),
            $attachmentName,
            $mimeType,
            $contentId
        );
    }

    public function toArray(): array
    {
        return [
            'Name' => $this->name,
            'Content' => $this->base64EncodedData,
            'ContentType' => $this->mimeType,
            'ContentId' => $this->contentId ?? $this->name
        ];
    }
}
