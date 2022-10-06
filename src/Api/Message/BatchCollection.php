<?php

namespace Ixdf\Postmark\Api\Message;

use App\Exceptions\Notification\BatchMailer\TooManyRecipients;
use Illuminate\Support\Collection;

class BatchCollection extends Collection
{
    private const MAX_RECIPIENTS = 500;

    /** @var array<int, \Ixdf\Postmark\Api\Message\BatchMessage> $items */
    protected $items = [];

    /**
     * @throws \App\Exceptions\Notification\BatchMailer\TooManyRecipients
     */
    public function push(...$values): self
    {
        if (count($this->items) >= self::MAX_RECIPIENTS) {
            throw new TooManyRecipients();
        }

        return parent::push($values);
    }

    public function toJson($options = 0): string
    {
        $items = [];

        /** @var \Ixdf\Postmark\Api\Message\BatchMessage $message */
        foreach ($this->toArray() as $message) {
            $items[] = $message->toArray();
        }

        return json_encode($items);
    }
}
