<?php

namespace App\Controllers;

use App\ApplicationServices\UserApplicationService;
use App\Services\AuthService;
use Framework\Config;
use Framework\Request;
use Framework\Response;


class AuthController
{
    private AuthService $authService;
    private UserApplicationService $appService;

    public function __construct()
    {
        $config = Config::getEnv();
        $this->authService = new AuthService($config['jwt_key'], $config['domain']);
        $this->appService = new UserApplicationService;
    }

    public function register(Request $request): Response
    {
        $params = $request->getPostParams();
        $res = $this->appService->createUser(
            $params['name'],
            $params['email'],
            $params['password'],
        );

        return new Response($res);
    }

    public function login(Request $request): Response
    {
        session_start();

        $params = $request->getPostParams();

        $result = $this->appService->login($params['email'], $params['password']);

        if($result['success'] === false){
            return new Response($result['message'], 401);
        }

        // セッションに認証用のトークン、CSRFトークンをそれぞれセット
        $jwt = $this->authService->generateJWT($result['userId']);
        $csrfToken = $this->authService->generateCsrfToken();

        $_SESSION['csrf_token'] = $csrfToken;

        $res = new Response(['message' => 'Login successful.']);
        $res->setTokenInCookie('jwt', $jwt);
        $res->setTokenInCookie('csrf_token', $csrfToken);

        return $res;
    }

    public function user(Request $request): Response
    {
        $authInfo = $this->authService->authenticate($request);

        if (!$authInfo['success']) {
            return new Response(['message' => $authInfo['message']], 401);
        }

        $user = $this->appService->getUser($authInfo['user_id']);

        $res = new Response($user);
        $res->setTokenInCookie('csrf_token', $authInfo['csrf_token']);

        return $res;
    }

    public function logout()
    {
        session_start();
        session_destroy();

        // クッキーの有効期限を過去の日付に設定して削除
        $res = new Response(["message" => "Logout successful."]);
        $res->setTokenInCookie('jwt', '', time() - 1);
        $res->setTokenInCookie('csrf_token', '', time() - 1);

        return $res;
    }
}
