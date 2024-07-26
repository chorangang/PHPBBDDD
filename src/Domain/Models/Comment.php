<?php

namespace App\Domain\Models;


class Comment
{
    private int $id;
    private int $userId;
    private int $threadId;
    private ?string $body;
    private bool $upvotes;
    private $createdAt;
    private $updatedAt;

    public function __construct(
        int $id,
        int $userId,
        int $threadId,
        ?string $body,
        bool $upvotes = false,
        string $createdAt = null,
        string $updatedAt = null
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->threadId = $threadId;
        $this->body = $body;
        $this->upvotes = $upvotes;
        $this->createdAt = $createdAt ?? date('Y-m-d H:i:s', time());
        $this->updatedAt = $updatedAt ?? date('Y-m-d H:i:s', time());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getThreadId(): int
    {
        return $this->threadId;
    }

    public function setThreadId(int $threadId): self
    {
        $this->threadId = $threadId;
        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function getUpvotes(): bool
    {
        return $this->upvotes;
    }

    public function setUpvotes(bool $upvotes): self
    {
        $this->upvotes = $upvotes;
        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}