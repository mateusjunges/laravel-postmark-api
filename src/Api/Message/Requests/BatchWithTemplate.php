<?php declare(strict_types=1);

namespace Ixdf\Postmark\Api\Message\Requests;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Ixdf\Postmark\Concerns\InteractWithBatches;
use Ixdf\Postmark\Exceptions\TooManyRecipients;

final class BatchWithTemplate implements Arrayable, Jsonable
{
    use InteractWithBatches;

    private const MAX_RECIPIENTS = 500;

    private ?string $templateAlias = null;
    private ?int $templateId = null;

    /** @var array<int, \Ixdf\Postmark\Api\Message\Requests\EmailWithTemplate> $items */
    private array $items = [];

    public function push(EmailWithTemplate $emailWithTemplate): self
    {
        if (count($this->items) >= self::MAX_RECIPIENTS) {
            throw new TooManyRecipients();
        }

        $this->items[] = $emailWithTemplate->setMessageStream('broadcast');

        return $this;
    }

    public function setTemplateId(int $templateId): self
    {
        $this->templateId = $templateId;

        return $this;
    }

    public function setTemplateAlias(string $templateAlias): self
    {
        $this->templateAlias = $templateAlias;

        return $this;
    }

    public function toArray(): array
    {
        $response = [];

        foreach ($this->items as $email) {
            if ($email->shouldSetTemplateIdOrAlias()) {
                if ($this->templateId !== null) {
                    $email->setTemplateId($this->templateId);
                } elseif ($this->templateAlias !== null) {
                    $email->setTemplateAlias($this->templateAlias);
                }
            }

            $response[] = $email->toArray();
        }

        return ['Messages' => $response];
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray());
    }
}
