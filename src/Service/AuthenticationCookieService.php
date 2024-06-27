<?php

namespace Service;

use Model\User;
use Repository\UserRepository;

class AuthenticationCookieService implements AuthenticationInterface
{
    private UserRepository $userRepository;
    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }
    public function check(): bool
    {
        if (isset($_COOKIE['user_id'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getUser(): ?\Entity\User
    {
        if (!$this->check()) {
            return null;
        } else {
            $userId = $_COOKIE['user_id'];
            return $this->userRepository->getById($userId);
        }
    }

    public function authenticate(string $email, string $password): bool
    {
        $user = User::getUserByEmail($email);
        if ($user) {
            if (password_verify($password, $user->getPassword())) {
                setcookie('user_id', $user->getId(), time() + 86400, "/");
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
    }
}