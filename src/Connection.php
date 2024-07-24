<?php
 class Connection implements ConnectionInterface
{
    public function connect(): PDO
    {
        $host = getenv('DB_HOST');
        $db = getenv('DB_NAME');
        $port = getenv('DB_PORT');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');
        return new PDO("pgsql:host=$host;port=$port;dbname=$db", "$user", "$password");
    }

 }