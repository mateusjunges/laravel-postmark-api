<?php declare(strict_types=1);

namespace Junges\Postmark\Api\Message\Requests;

final class Address
{
    public function __construct(
        public readonly string $emailAddress,
        public readonly ?string $fullName = null
    ) {}

    public function fullName(): string
    {
        return $this->fullName !== null
            ? $this->fullName
            : $this->emailAddress;
    }
}