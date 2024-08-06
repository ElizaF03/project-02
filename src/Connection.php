<?php



class Connection implements ConnectionInterface
{
    protected PDO $pdo;
    protected static $_instance;

    private function __construct()
    {
        $host = getenv('DB_HOST');
        $db = getenv('DB_NAME');
        $port = getenv('DB_PORT');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');
        $this->pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", "$user", "$password");
    }

    public static function getInstance(): Connection
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    public function execute(string $query, ?array $params): false|PDOStatement
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    public function query(string $stmt): false|PDOStatement
    {
        return $this->pdo->query($stmt);
    }

    public function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->pdo->commit();
    }

    public function rollBack(): bool
    {
        return $this->pdo->rollBack();
    }
}