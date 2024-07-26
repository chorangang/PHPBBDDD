<?php

namespace App\Repositories;

use App\Domain\Models\User;
use PDO;

class UserRepository extends Repository
{
    public function findById(int $id): ?User
    {
        $stmt = $this->db->prepare('SELECT * FROM Users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->getUserModel($user);
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare('SELECT * FROM Users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->getUserModel($user);
    }

    public function list(array $userIds): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM Users where id IN (:userIds)');
        $stmt->execute(['userIds' => implode(',', $userIds)]);

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($users === false) return null;

        return (array) array_map(fn($user) => $this->getUserModel($user), $users);
    }

    public function create(User $user): ?User
    {
        $stmt = $this->db->prepare(
            'INSERT INTO Users (name, email, password, created_at, updated_at)'
            . ' ' .
            'VALUES (:name, :email, :password, :created_at, :updated_at)'
        );

        $stmt->execute([
            ':name' => $user->getName(),
            ':email' => $user->getEmail(),
            ':password' => $user->getHashedPassword(),
            ':created_at' => $user->getCreatedAt(),
            ':updated_at' => $user->getUpdatedAt()
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->getUserModel($user, $this->db->lastInsertId());
    }

    private function getUserModel(array|bool $user, ?int $id = null): ?User
    {
        if($user === false){
            return null;
        }

        $userId = is_null($id) ? $user['id'] : $id;

        return new User(
            $user['name'],
            $user['email'],
            $user['password'],
            $user['created_at'],
            $user['updated_at'],
            $userId
        );
    }
}
