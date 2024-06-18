<?php

namespace Repository;

use Entity\User;

class UserRepository extends Repository
{
    public function addInfo(string $username, string $email, string $password): void
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt =  $this->pdo->prepare('INSERT INTO users (username, email, password) VALUES(:username, :email, :password)');
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password]);
    }

    public function getUserByEmail(string $email): ?User
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        } else {
            return $this->hydrate($result);
        }
    }

    public function getById(int $id): ?User
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
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