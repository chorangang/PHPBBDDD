<?php

namespace App\ApplicationServices;

use App\Domain\DomainServices\UserDomainService;
use App\Domain\Models\User;
use App\Repositories\UserRepository;
use App\Traits\ResponseTrait;


class UserApplicationService
{
    use ResponseTrait;

    public function login(string $email, string $password): array
    {
        // メールでUserを検索
        $user = (new UserRepository)->findByEmail($email);

        // メールで引っかからなければユーザーがいないよって返す
        if ($user === null) {
            return $this->failResponse(404, "User not found.");
        }

        // パスワードを照合して間違ってれば間違ってるよって返す
        if (!password_verify($password, $user->getPassword())) {
            return $this->failResponse(400, "Password is incorrect.");
        }

        // メールもパスワードも正しいならuserIdを返す
        $result['userId'] = $user->getId();

        return $result;
    }

    public function getUser(int $id): array
    {
        $user = (new UserRepository)->findById($id);

        if($user === null){
            return ['message' => 'User not found.'];
        }

        return $this->getUserArray($user, 'User created successfully.');
    }

    public function createUser(string $name, string $email, string $password): array
    {
        $user = new User($name, $email, $password);

        // ユーザーがすでに登録されていないか確認
        if ((new UserDomainService)->exists($user)) {
            return $result = [
                'success' => false,
                'message' => "User has already registered."
            ];
        }

        $user = (new UserRepository)->create($user);

        return $this->getUserArray($user, 'User created successfully.');
    }
}
