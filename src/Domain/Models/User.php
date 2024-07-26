<?php

namespace App\Domain\Models;

use App\Domain\ValueObjects\User\UserName;
use App\Domain\ValueObjects\User\Email;
use App\Domain\ValueObjects\User\Password;
use App\Exceptions\InvalidArgumentException;

class User
{
    private ?int $id = null; // 識別子
    private UserName $name;
    private Email $email;
    private Password $password;
    private string $created_at;
    private string $updated_at;

    public function __construct(
        string $name,
        string $email,
        string $password,
        string $created_at = null,
        string $updated_at = null,
        ?int $id = null,
    ) {
        $this->setName($name)
            ->setEmail($email)
            ->setPassword($password)
            ->setCreatedAt($created_at ?? date('Y-m-d H:i:s', time()))
            ->setUpdatedAt($updated_at ?? date('Y-m-d H:i:s', time()))
            ->setId((int)$id);
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = new UserName($name);
        return $this;
    }

    public function getName(): string
    {
        return $this->name->getValue();
    }

    public function setEmail(string $email): self
    {
        $this->email = new Email($email);
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email->getValue();
    }

    public function setPassword(string $password): self
    {
        $this->password = new Password($password);
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password->getValue();
    }

    public function getHashedPassword(): string
    {
        return password_hash($this->password->getValue(), PASSWORD_DEFAULT);
    }

    private function setCreatedAt(string $timestamp): self
    {
        $this->created_at = $timestamp;
        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }

    private function setUpdatedAt(string $timestamp): self
    {
        $this->updated_at = $timestamp;
        return $this;
    }

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
}