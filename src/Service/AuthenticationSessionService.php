<?php

namespace Service;

use Entity\User;
use Repository\UserRepository;

class AuthenticationSessionService implements AuthenticationInterface
{
    private $userRepository;
    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }
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
            return $this->userRepository->getById($userId);
        }
    }

    public function authenticate(string $email, string $password): bool
    {
        $user = $this->userRepository->getUserByEmail($email);
        if ($user) {
            if (password_verify($password, $user->getPassword())) {
                session_start();
                $_SESSION['user_id'] = $user->getId();
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
    }
}