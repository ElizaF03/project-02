<?php

namespace Controller;

use Model\User;
use Request\LoginRequest;
use Request\RegistrationRequest;
use Service\AuthenticationService;

class UserController
{

    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
    }
    public function getRegistration(): void
    {
        require_once '../View/get_registration.php';
    }


    public function registration(RegistrationRequest $request): void
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $username = $request->getName();
            $email = $request->getEmail();
            $password = $request->getPassword();
            User::addInfo($username, $email, $password);
            header('Location: /login');
        } else {
            require_once '../View/get_registration.php';
        }
    }

    public function getLogin(): void
    {
        require_once '../View/get_login.php';
    }

    public function logout(): void
    {
        session_start();
        $_SESSION['user_id'] = '';
        session_destroy();
        header('Location: /login');
    }



    public function login(LoginRequest $request): void
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $email = $request->getEmail();
            $password = $request->getPassword();
            $user = User::getUserByEmail($email);
            if ($user) {
                if (password_verify($password, $user->getPassword())) {
                    $this->authenticationService->authenticate($user->getId());
                   // $_SESSION['user_id'] = $user->getId();
                    header('Location: /catalog');
                } else {
                    $errors['password'] = 'Incorrect password';
                }
            } else {
                $errors['email'] = 'User is not registered';
            }
        }
        require_once '../View/get_login.php';
    }

}