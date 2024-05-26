<?php

namespace Request;

use Model\User;

class RegistrationRequest
{
    private string $uri;
    private string $method;
    private array $data;

    public function __construct(string $uri, string $method, array $data = [])
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->data = $data;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getName(): string
    {
        return $this->data['name'];
    }

    public function getEmail(): string
    {
        return $this->data['email'];
    }

    public function getPassword(): string
    {
        return $this->data['password'];
    }

    public function getRepPassword(): string
    {
        return $this->data['repeat-password'];
    }

    public function validate(): array
    {
        $errors = [];
        if (strlen($this->getName()) < 2) {
            $errors['name'] = 'Name is too short';
        }
        if (!filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }

        $user = User::getUserByEmail($this->getEmail());
        if ($user) {
            if ($user->getEmail() === $this->getEmail()) {
                $errors['email'] = 'Email already exists';
            }
        } elseif (!filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }
        if (preg_match("/^[a-zA-Z0-9]+$/", $this->getPassword()) || strlen($this->getPassword()) < 6) {
            $errors['password'] = 'Password must contain as many as 6 characters including lower-case, upper-case, numbers and symbols.';
        }

        if ($this->getRepPassword() != $this->getPassword()) {
            $errors['pswRepeat'] = 'Errors matching password';
        }
        return $errors;
    }
}