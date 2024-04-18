<?php
require_once 'Model.php';

class User extends Model
{
    private int $id;
    private string $username;
    private string $email;
    private string $password;



    public function registration(string $username, string $email, string $password): void
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->getPdo()->prepare('INSERT INTO users (username, email, password) VALUES(:username, :email, :password)');
        $stmt->execute(array('username' => $username, 'email' => $email, 'password' => $password));
    }

    public function getUserByEmail(string $email): array
    {
        $stmt = $this->getPdo()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }
}