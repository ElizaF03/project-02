<?php

namespace Repository;

use PDO;

class Repository
{
    private static PDO $pdo;

    public function getPdo(): PDO
    {
        $host = getenv('DB_HOST');
        $db = getenv('DB_NAME');
        $port = getenv('DB_PORT');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');
        return self::$pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", "$user", "$password");
    }
}