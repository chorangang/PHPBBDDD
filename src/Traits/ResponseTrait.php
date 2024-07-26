<?php

namespace App\Traits;

use App\Domain\Models\Comment;
use App\Domain\Models\Thread;
use App\Domain\Models\User;

trait ResponseTrait
{
    public function successResponse(int $status, string $msg)
    {
        return [
            'status'  => $status,
            'message' => $msg,
        ];
    }

    public function failResponse(int $status, string $msg)
    {
        return [
            'status'  => $status,
            'message' => $msg,
        ];
    }

    private function getUserArray(User $user)
    {
        return [
            'id'    => $user->getId(),
            'name'  => $user->getName(),
            'email' => $user->getEmail(),
        ];
    }

    private function getThreadArray(Thread $thread, User $user)
    {
        return [
            'id'         => $thread->getId(),
            'user'       => $this->getUserArray($user),
            'title'      => $thread->getTitle(),
            'body'       => $thread->getBody(),
            'created_at' => $thread->getCreatedAt(),
            'updated_at' => $thread->getUpdatedAt()
        ];
    }

    private function getCommentArray(Comment $comment, User $user): array
    {
        return [
            'id'         => $comment->getId(),
            'user'       => $this->getUserArray($user),
            'thread'     => $comment->getThreadId(),
            'body'       => $comment->getBody(),
            'upvotes'    => $comment->getUpvotes(),
            'created_at' => $comment->getCreatedAt(),
            'updated_at' => $comment->getUpdatedAt()
        ];
    }
}