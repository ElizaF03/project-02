<?php

namespace Controller;


use Repository\UserRepository;
use Request\LoginRequest;
use Request\RegistrationRequest;
use Service\AuthenticationInterface;

class UserController
{

    private AuthenticationInterface $authenticationService;
    private UserRepository $userRepository;


    public function __construct(AuthenticationInterface $authenticationService, UserRepository $userRepository)
    {
        $this->authenticationService = $authenticationService;
        $this->userRepository = $userRepository;
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
             $this->userRepository->addInfo($username, $email, $password);
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
        $this->authenticationService->logout();
        header('Location: /login');
    }


    public function login(LoginRequest $request): void
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $email = $request->getEmail();
            $password = $request->getPassword();
            $result = $this->authenticationService->authenticate($email, $password);
            if ($result) {
                header('Location: /catalog');
            } else {
                $errors['email'] = 'Login or password is incorrect';
            }
        }
        require_once '../View/get_login.php';
    }
}