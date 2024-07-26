<?php

namespace App\Domain\Models;

use App\Domain\ValueObjects\Thread\Body;
use App\Domain\ValueObjects\Thread\Title;


class Thread
{
    private ?int $id;
    private int $userId;
    private Title $title;
    private Body $body;
    private string $createdAt;
    private string $updatedAt;

    public function __construct(
        int $userId,
        string $title,
        string $body,
        string $createdAt = null,
        string $updatedAt = null,
        int $id = null,
    ) {
        $this->setUserId($userId);
        $this->setTitle($title);
        $this->setBody($body);
        $this->setCreatedAt($createdAt ?? date('Y-m-d H:i:s', time()));
        $this->setUpdatedAt($updatedAt ?? date('Y-m-d H:i:s', time()));
        $this->setId($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId($userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getTitle()
    {
        return $this->title->getValue();
    }

    public function setTitle(string $title): self
    {
        $this->title = new Title($title);
        return $this;
    }

    public function getBody(): string
    {
        return $this->body->getValue();
    }

    public function setBody(string $body): self
    {
        $this->body = new Body($body);
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
