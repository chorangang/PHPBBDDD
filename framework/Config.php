<?php

namespace Framework;

class Config
{
    public static function getEnv(): array
    {
        return [
            "user"     => $_ENV["MYSQL_USER"],
            "password" => $_ENV["MYSQL_PASSWORD"],
            "host"     => $_ENV["HOST"],
            "dbname"   => $_ENV["MYSQL_DATABASE"],
            "jwt_key"  => $_ENV["JWT_KEY"],
            "expire"   => $_ENV["EXPIRE"],
            "path"     => $_ENV['PATH'],
            "domain"   => $_ENV['DOMAIN'],
            "secure"   => $_ENV['SECURE'] === "true" ? true : false,
            "httponly"   => $_ENV['HTTPONLY'] === "true" ? true : false,
        ];
    }
}