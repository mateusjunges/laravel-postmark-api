<?php declare(strict_types=1);

namespace Ixdf\Postmark\Models\Message;

use Illuminate\Support\Collection;
use Ixdf\Postmark\Exceptions\TooManyRecipients;

final class BatchCollection extends Collection
{
    private const MAX_RECIPIENTS = 500;

    /** @var array<int, \Ixdf\Postmark\Models\Message\BatchMessage> $items */
    protected $items = [];

    /**
     * @throws \Ixdf\Postmark\Exceptions\TooManyRecipients
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

        /** @var \Ixdf\Postmark\Models\Message\BatchMessage $message */
        foreach ($this->toArray() as $message) {
            $items[] = $message->toArray();
        }

        return json_encode($items);
    }
}
