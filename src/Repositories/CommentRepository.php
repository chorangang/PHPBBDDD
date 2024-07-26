<?php

namespace App\Repositories;

use App\Domain\Models\Comment;
use PDO;

class CommentRepository extends Repository
{
    public function find(int $id): ?Comment
    {
        $stmt = $this->db->prepare('SELECT * FROM Comments WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $comment = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->getCommentModel($comment);
    }

    public function list(int $threadId): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM Comments WHERE thread_id = :threadId');
        $stmt->execute(['threadId' => $threadId]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($comments === false) return null;

        return $this->getCommentsModel($comments);
    }

    public function create(array $commentData): bool {
        $stmt = $this->db->prepare(
            'INSERT INTO Comments (user_id, thread_id, body, upvotes, created_at, updated_at)'
            . ' ' .
            'VALUES (:user_id, :thread_id, :body, :upvotes, :created_at, :updated_at)'
        );

        return $stmt->execute([
            'user_id' => $commentData['user_id'],
            'thread_id' => $commentData['thread_id'],
            'body' => $commentData['body'],
            'upvotes' => $commentData['upvotes'],
            'created_at' => $commentData['created_at'] ?? date('Y-m-d H:i:s', time()),
            'updated_at' => $commentData['updated_at'] ?? date('Y-m-d H:i:s', time()),
        ]);
    }

    public function update(array $data, int $id): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE Comments SET body = :body, upvotes = :upvotes, updated_at = :updated_at WHERE id = :id'
        );
        return $stmt->execute([
            'id' => $id,
            'body' => $data['body'],
            'upvotes' => $data['upvotes'],
            'updated_at' => $data['updated_at'] ?? date('Y-m-d H:i:s', time()),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM Comments WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    private function getCommentModel(array|bool $comment): ?Comment
    {
        if($comment === false) return null;

        return new Comment(
            $comment['id'],
            $comment['user_id'],
            $comment['thread_id'],
            $comment['body'],
            $comment['upvotes'],
            $comment['created_at'],
            $comment['updated_at']
        );
    }

    private function getCommentsModel(array $comments): array
    {
        if($comments === false) return null;

        return array_map(fn($comment) => $this->getCommentModel($comment), $comments);
    }
}
