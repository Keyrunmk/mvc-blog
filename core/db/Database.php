<?php

declare(strict_types=1);

namespace App\core\db;

use PDOStatement;

class Database
{
    public \PDO $pdo;

    public function __construct(array $config)
    {
        $dsn = $config["dsn"] ?? "";
        $user = $config["user"] ?? "";
        $password = $config["password"] ?? "";
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function prepare(string $sql): PDOStatement|false
    {
        return $this->pdo->prepare($sql);
    }
}
