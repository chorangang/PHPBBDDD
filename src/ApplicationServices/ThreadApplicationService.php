<?php

namespace App\ApplicationServices;

use App\Domain\Models\Thread;
use App\Repositories\UserRepository;
use App\Repositories\ThreadRepository;
use App\Traits\ResponseTrait;
use InvalidArgumentException;


class ThreadApplicationService
{
    use ResponseTrait;

    public function getThread(int $id)
    {
        $thread = (new ThreadRepository)->find($id);

        if ($thread === null) {
            return $this->failResponse(404, 'BBS cannot get the thread.');
        }

        $user = (new UserRepository)->findById($thread->getUserId());

        return $this->getThreadArray($thread, $user);
    }

    public function getThreads(array $params): array
    {
        $threads = (new ThreadRepository)->all(
            $params['page'],
            $params['page_size'] ?? 20,
            $params['sort'] ?? 'created_at',
            $params['order'] ?? 'desc',
            $params['search'] ?? null
        );

        // Nullの時は空配列を返す
        if($threads === null){
            return [];
        }

        // ユーザーを取得して結合して返す
        return (array) array_map(function ($thread) {
            $user = (new UserRepository)->findById($thread->getUserId());
            return $this->getThreadArray($thread, $user);
        }, $threads);
    }

    public function createThread(int $userId, string $title, string $body)
    {
        try {
            $thread = new Thread($userId, $title, $body);

            if((new ThreadRepository)->save($thread) === null){
                return $this->failResponse(400, "store failed.");
            }

            $user = (new UserRepository)->findById($userId);

            return $this->getThreadArray($thread, $user);
        } catch (InvalidArgumentException $e) {
            return $this->failResponse(400, $e->getMessage());
        }
    }

    public function updateThread(int $id, string $title, string $body): array
    {
        $thread = (new ThreadRepository)->find($id);

        if ($thread === null) {
            return $this->failResponse(404, 'BBS cannot get the thread.');
        }

        $newThread = (new ThreadRepository)->update($thread->setTitle($title)->setBody($body));
        $user = (new UserRepository)->findById($newThread->getUserId());

        return $this->getThreadArray($newThread, $user);
    }

    public function deleteThread(int $id): array
    {
        $res = (new ThreadRepository)->delete($id);

        if($res === false){
            return $this->failResponse(400, "fail to delete.");
        }

        return $this->successResponse(200, "delete successful!");
    }
}