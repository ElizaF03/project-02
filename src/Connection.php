<?php

class Connection implements ConnectionInterface
{
    private PDO $pdo;

    public function __construct()
    {
        $host = getenv('DB_HOST');
        $db = getenv('DB_NAME');
        $port = getenv('DB_PORT');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');
        $this->pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", "$user", "$password");
    }

    public function execute(string $stmt, ?array $query): false|PDOStatement
    {
        $stmt = $this->pdo->prepare($stmt);
        $stmt->execute($query);
        return $stmt;
    }

    public function query(string $stmt): false|PDOStatement
    {
        return $this->pdo->query($stmt);
    }
}