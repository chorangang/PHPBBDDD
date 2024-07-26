<?php

namespace App\Domain\ValueObjects\User;

use App\Domain\ValueObjects\ValueObjectBase;
use App\Exceptions\InvalidArgumentException;

class UserName extends ValueObjectBase
{
    public const MAX_LENGTH = 20;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public function validate(string $value): void
    {
        if ($value === '') {
            throw new InvalidArgumentException('UserName is required.');
        }

        if (mb_strlen($value) > self::MAX_LENGTH) {
            throw new InvalidArgumentException('UserName must be less than ' . self::MAX_LENGTH);
        }
    }
}