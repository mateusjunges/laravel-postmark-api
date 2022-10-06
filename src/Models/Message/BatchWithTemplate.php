<?php declare(strict_types=1);

namespace Ixdf\Postmark\Models\Message;

use Ixdf\Postmark\Exceptions\TooManyRecipients;

final class BatchWithTemplate
{
    private const MAX_RECIPIENTS = 500;

    /** @var array<int, \Ixdf\Postmark\Models\Message\EmailWithTemplate> $items */
    private array $items = [];

    public function push(EmailWithTemplate $emailWithTemplate): self
    {
        if (count($this->items) >= self::MAX_RECIPIENTS) {
            throw new TooManyRecipients();
        }

        $this->items[] = $emailWithTemplate->setMessageStream('broadcast');

        return $this;
    }

    public function toArray(): array
    {
        $response = [];

        foreach ($this->items as $email) {
            $response[] = $email->toArray();
        }

        return ['Messages' => $response];
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray());
    }
}
