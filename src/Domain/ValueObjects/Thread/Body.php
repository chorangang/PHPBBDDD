<?php

namespace App\Domain\ValueObjects\Thread;

use App\Domain\ValueObjects\ValueObjectBase;


class Body extends ValueObjectBase
{
    private const MAX_LENGTH = 1024;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    private function validate(string $value): void
    {
        if (mb_strlen($value) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException('Body exceeds maximum length');
        }
    }
}
