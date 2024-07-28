<?php

namespace Repository;

use ConnectionInterface;
use Entity\User;

class UserRepository
{
    private ConnectionInterface $connection;
    public function __construct(ConnectionInterface $connection){
        $this->connection = $connection;
    }
    public function addInfo(string $username, string $email, string $password): void
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
         $this->connection->execute('INSERT INTO users (username, email, password) VALUES(:username, :email, :password)',(['username' => $username, 'email' => $email, 'password' => $password]));
    }

    public function getUserByEmail(string $email): ?User
    {
        $stmt = $this->connection->execute("SELECT * FROM users WHERE email = :email", (['email' => $email]));
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        } else {
            return $this->hydrate($result);
        }
    }

    public function getById(int $id): ?User
    {
        $stmt = $this->connection->execute("SELECT * FROM users WHERE id = :id",(['id' => $id]));
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        } else {
            return $this->hydrate($result);
        }
    }

    private function hydrate(array $data): User
    {
        $obj = new User($data["id"], $data["username"], $data["email"], $data["password"]);
        return $obj;
    }
}