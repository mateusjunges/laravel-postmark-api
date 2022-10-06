<?php

namespace Ixdf\Postmark\Api\Message;

use Illuminate\Support\Collection;

class BatchCollection extends Collection
{
    /** @var array<int, \Ixdf\Postmark\Api\Message\BatchMessage> $items */
    protected $items = [];

    public function toJson($options = 0): string
    {
        $items = [];

        foreach ($this->toArray() as $message) {
            $items[] = $message->toArray();
        }

        return json_encode($items);
    }
}
