<?php

namespace App\Domain\ValueObjects\User;

use App\Domain\ValueObjects\ValueObjectBase;
use App\Exceptions\InvalidArgumentException;

class Password extends ValueObjectBase
{
    public const MIN_LENGTH = 8;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    private function validate(string $value)
    {
        // 最低文字数のチェック
        if (strlen($value) < self::MIN_LENGTH) {
            throw new InvalidArgumentException('Password must be at least ' . self::MIN_LENGTH . ' characters long.');
        }
        // 英大文字、小文字、数字、特殊文字のチェック
        if (!preg_match('/[A-Z]/', $value)) {
            throw new InvalidArgumentException('Password must contain at least one uppercase letter.');
        }
        if (!preg_match('/[a-z]/', $value)) {
            throw new InvalidArgumentException('Password must contain at least one lowercase letter.');
        }
        if (!preg_match('/[0-9]/', $value)) {
            throw new InvalidArgumentException('Password must contain at least one number.');
        }
        if (!preg_match('/[\W_]/', $value)) {  // \W は特殊文字を意味し、_ も含める
            throw new InvalidArgumentException('Password must contain at least one special character.');
        }
    }
}
