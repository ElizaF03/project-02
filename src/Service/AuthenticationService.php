<?php

namespace Service;

class AuthenticationService
{
    public function check(): bool
    {
        session_start();
        if ($this->getSession()) {
            return true;
        } else {
            return false;
        }
    }

    public function getSession(): bool
    {
        return $_SESSION['user_id'] ?? false;
    }

    public function authenticate(int $userId): void
    {
        session_start();
        $_SESSION['user_id'] = $userId;
    }
}