<?php

namespace Framework;

class Request
{
    public function __construct(
        public readonly array $getParams,
        public readonly array $postParams,
        public readonly array $cookie,
        public readonly array $files,
        public readonly array $server
    ) {
    }

    public static function createFromGlobals(): static
    {
        return new static($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER);
    }

    public function getPathInfo(): string
    {
        return strtok($this->server["REQUEST_URI"], "?");
    }

    public function getMethod(): string
    {
        return $this->server["REQUEST_METHOD"];
    }

    public function getParams(): array
    {
        return $this->getParams;
    }

    public function getPostParams(): array
    {
        // JSON形式のPOSTデータを取得する
        $input = file_get_contents('php://input');
        return json_decode($input, true);
    }

    public function getCookie(string $name): ?string
    {
        return $this->cookie[$name] ?? null;
    }

    public function getCookies(): array
    {
        return $this->cookie;
    }
}
