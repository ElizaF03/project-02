<?php

namespace Model;

class User extends Model
{
    private int $id;
    private string $username;
    private string $email;
    private string $password;

    public function __construct(int $id, string $username, string $email, string $password)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public static function addInfo(string $username, string $email, string $password): void
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = self::getPdo()->prepare('INSERT INTO users (username, email, password) VALUES(:username, :email, :password)');
        $stmt->execute(array('username' => $username, 'email' => $email, 'password' => $password));
    }

    public static function getUserByEmail(string $email): ?User
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        } else {
            return self::hydrate($result);
        }
    }

    public static function getById(int $id): ?User
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        } else {
            return self::hydrate($result);
        }
    }

    private static function hydrate(array $data): User
    {
        $obj = new self($data["id"], $data["username"], $data["email"], $data["password"]);
        return $obj;
    }
}