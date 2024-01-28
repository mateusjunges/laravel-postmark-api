<?php declare(strict_types=1);

namespace Junges\Postmark\Api\Message\Requests;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Junges\Postmark\Concerns\InteractWithBatches;
use Junges\Postmark\Exceptions\TooManyRecipients;

final class Batch implements Arrayable, Jsonable
{
    use InteractWithBatches;

    private const MAX_RECIPIENTS = 500;

    /** @var array<int, \Junges\Postmark\Api\Message\Requests\Message> $items */
    private array $items = [];

    /**
     * @throws \Junges\Postmark\Exceptions\TooManyRecipients
     */
    public function push(Message $message): self
    {
        if (count($this->items) >= self::MAX_RECIPIENTS) {
            throw new TooManyRecipients();
        }

        $this->items[] = $message;

        return $this;
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function toJson($options = 0): string
    {
        $items = [];

        foreach ($this->toArray() as $message) {
            $items[] = $message->toArray();
        }

        return json_encode($items);
    }
}
