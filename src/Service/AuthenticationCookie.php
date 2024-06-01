<?php

namespace Service;

use Model\User;

class AuthenticationCookie implements Authentication
{
    public function check(): bool
    {
        if (isset($_COOKIE['user_id'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getUser(): ?User
    {
        if (!$this->check()) {
            return null;
        } else {
            $userId = $_COOKIE['user_id'];
            return User::getById($userId);
        }
    }

    public function authenticate(string $email, string $password):bool
    {
        $user = User::getUserByEmail($email);
        if ($user) {
            if (password_verify($password, $user->getPassword())) {
                setcookie('user_id', $user->getId(), time() + (86400 * 30), "/");
                header('Location: /catalog');
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function logout(): void
    {
        setcookie('user_id', '', time() - 3600);
        // TODO: Implement logout() method.
    }
}