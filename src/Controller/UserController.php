<?php

namespace Controller;

use Model\User;
use Request\LoginRequest;
use Request\RegistrationRequest;
use Service\AuthenticationCookie;
use Service\AuthenticationService;

class UserController
{

    private AuthenticationService $authenticationService;
    private AuthenticationCookie  $authenticationCookie;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
        $this->authenticationCookie = new AuthenticationCookie();
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
        $this->authenticationCookie->logout();
        header('Location: /login');
    }


    public function login(LoginRequest $request): void
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $email = $request->getEmail();
            $password = $request->getPassword();
            $result = $this->authenticationCookie->authenticate($email, $password);
            if ($result) {
                header('Location: /catalog');
            } else {
                $errors['email'] = 'Login or password is incorrect';
            }
        }
        require_once '../View/get_login.php';
    }
}