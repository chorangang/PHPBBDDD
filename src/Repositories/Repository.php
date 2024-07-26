<?php

namespace App\Repositories;

use Framework\Config;
use PDO;

class Repository
{
    protected PDO $db;

    public function __construct()
    {
        $config = Config::getEnv();

        $this->db = new PDO(
            "mysql:host={$config['host']};dbname={$config['dbname']}",
            $config["user"],
            $config["password"]
        );
    }
}
