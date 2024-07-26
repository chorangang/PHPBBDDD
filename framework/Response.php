<?php

namespace Framework;

class Response
{
    private array $cookies = [];
    private array $config = [];

    public function __construct(private mixed $content = "", private int $status = 200)
    {
        // レスポンスヘッダーを送信
        header('Content-Type: application/json; charset=utf-8');

        $this->content = $content;
        $this->status = $status;

        $this->config = Config::getEnv();
    }

    public function send(): void
    {
        // クッキーを設定
        foreach ($this->cookies as $cookie) {
            setcookie(
                $cookie['name'],
                $cookie['value'],
                $cookie['expire'],
                $cookie['path'],
                $cookie['domain'],
                $cookie['secure'],
                $cookie['httponly']
            );
        }

        echo json_encode($this->content);
    }

    public function setTokenInCookie(string $name, string $value, ?int $expire = null): void {
        $expire = $expire === null
            ? time() + (int)$this->config['expire'] // Tokenの有効期限はENVで設定
            : time() + (int)$expire; // もしくは個別に設定もできる

        $this->cookies[$name] = [
            'name'     => $name,
            'value'    => $value,
            'expire'   => $expire,
            'path'     => $this->config['path'],
            'domain'   => $this->config['domain'],
            'secure'   => $this->config['secure'],
            'httponly' => $this->config['httponly'],
        ];
    }
}
