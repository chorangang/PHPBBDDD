<?php

namespace App\Domain\ValueObjects\Thread;

use App\Domain\ValueObjects\ValueObjectBase;
use InvalidArgumentException;


class Title extends ValueObjectBase
{
    private const MAX_LENGTH = 100;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    private function validate(string $value): void
    {
        // NullCheck
        if ($value === null) {
            throw new InvalidArgumentException('The title cannot be null.');
        }
        // 100文字以内
        if (strlen($value) > self::MAX_LENGTH) {
            throw new InvalidArgumentException('The title must be within 100 characters.');
        }
    }
}