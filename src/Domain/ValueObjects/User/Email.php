<?php

namespace App\Domain\ValueObjects\User;

use App\Domain\ValueObjects\ValueObjectBase;
use App\Exceptions\InvalidArgumentException;

class Email extends ValueObjectBase
{
    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    private function validate(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Email is invalid.');
        }
    }
}
