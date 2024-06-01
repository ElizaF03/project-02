<?php

namespace Service;

use Model\User;

class AuthenticationService implements Authentication
{
    public function check(): bool
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getUser(): ?User
    {
        session_start();
        if (!$this->check()) {
            return null;
        } else {
            $userId = $_SESSION['user_id'];
            return User::getById($userId);
        }
    }

    public function authenticate(string $email, string $password):bool
    {
        $user = User::getUserByEmail($email);
        if ($user) {
            if (password_verify($password, $user->getPassword())) {
                session_start();
                $_SESSION['user_id'] = $user->getId();
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
        session_start();
        $_SESSION['user_id'] = null;
        session_destroy();
        // TODO: Implement logout() method.
    }
}