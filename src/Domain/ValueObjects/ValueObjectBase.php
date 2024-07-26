<?php

namespace App\Domain\ValueObjects;

class ValueObjectBase
{
    protected $value;

    public function getValue()
    {
        return $this->value;
    }
}