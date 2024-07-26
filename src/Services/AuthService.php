<?php

namespace App\Services;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Framework\Request;

class AuthService
{
    private string $secretKey;
    private string $domain;

    public function __construct(string $secretKey, string $domain)
    {
        $this->secretKey = $secretKey;
        $this->domain = $domain;
    }

    public function generateJWT($userId)
    {
        $payload = [
            'iss' => $this->domain, // 発行者
            'iat' => time(),             // 発行時間
            'exp' => time() + 3600,      // 有効期限（1時間）
            'sub' => $userId             // ユーザーID
        ];

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }

    public function generateCsrfToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    public function verifyJWT($token): array|bool
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            return (array)$decoded;
        } catch (Exception $e) {
            return false;
        }
    }

    public function verifyCsrfToken(string $token): bool
    {
        return $_SESSION['csrf_token'] === $token;
    }

    public function authenticate(Request $request): array
    {
        $result = [
            'success' => false,
            'message' => '',
            'user_id' => null,
        ];

        $jwt = $request->getCookie('jwt');
        $csrfToken = $request->getCookie('csrf_token');
        if (!$jwt || !$csrfToken) {
            $result['message'] = 'Please login.';
            return $result;
        }

        $decoded = $this->verifyJWT($jwt);
        if (!$decoded) {
            $result['message'] = 'Invalid token.';
            return $result;
        }

        session_start();
        if (!$this->verifyCsrfToken($_SESSION['csrf_token'], $csrfToken)) {
            $result['message'] = 'Invalid CSRF token.';
            return $result;
        }

        // Refresh CSRF token
        $_SESSION['csrf_token'] = $this->generateCsrfToken();

        $result['success'] = true;
        $result['user_id'] = $decoded['sub'];
        $result['csrf_token'] = $_SESSION['csrf_token'];

        return $result;
    }
}
