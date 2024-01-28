<?php

namespace Junges\Postmark\Concerns;

trait InteractWithBatches
{
    public function count(): int
    {
        return count($this->items);
    }

    public function all(): array
    {
        return $this->items;
    }
}
