<?php

namespace App\ApplicationServices;

use App\Domain\DomainServices\CommentDomainService;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use App\Traits\ResponseTrait;

class CommentApplicationService
{
    use ResponseTrait;

    public function getComments(int $threadId): array
    {
        $comments = (new CommentRepository)->list($threadId);
        if($comments === null) return $this->failResponse(404, "Comments not found.");

        $userIds = array_reduce($comments, function ($carry, $comment) {
            $carry[] = $comment->getUserId();
            return $carry;
        });

        $users = (new UserRepository)->list(array_unique($userIds));
        if($users === null) return $this->failResponse(404, "Users who commented not found.");

        return (array) array_map(function ($comment) use ($users) {
            $user = array_filter($users, function ($user) use ($comment) {
                return $comment->getUserId() === $user->getId();
            });
            return $this->getCommentArray($comment, $user[0]);
        }, $comments);
    }

    public function getComment(int $id): array
    {
        $comment = (new CommentRepository)->find($id);
        $user = (new UserRepository)->findById($comment->getUserId());

        return $this->getCommentArray($comment, $user);
    }

    public function createComment(array $commentData): array
    {
        $isSuccess = (new CommentRepository)->create($commentData);
        if(!$isSuccess) return $this->failResponse(400, "Comment failed!");

        return $this->successResponse(200, "Successfully commented!");
    }

    public function updateComment(array $commentData, int $id): array
    {
        $isExists = (new CommentDomainService)->exists($id);
        if($isExists) return $this->failResponse(400, "Comment not found.");

        $isSuccess = (new CommentRepository)->update($commentData, $id);
        if(!$isSuccess) return $this->failResponse(400, "Comment update failed!");

        return $this->successResponse(200, "Comment udpated!");
    }

    public function deleteComment(int $id): array
    {
        $isExists = (new CommentDomainService)->exists($id);
        if($isExists) return $this->failResponse(400, "Comment not found.");

        $isSuccess = (new CommentRepository)->delete($id);
        if(!$isSuccess) return $this->failResponse(400, "Comment delete failed!");

        return $this->successResponse(200, "Comment deleted!");
    }
}
