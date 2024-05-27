<?php

namespace Request;

class LoginRequest extends Request
{
    public function getEmail(): string
    {
        return $this->data['email'];
    }

    public function getPassword(): string
    {
        return $this->data['password'];
    }
    public function validate(): array
    {
        $errors = [];
        if (!filter_var($this->getEmail(), FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }
        if (preg_match("/^[a-zA-Z0-9]+$/", $this->getPassword()) || strlen($this->getPassword()) < 6) {
            $errors['password'] = 'Password must contain as many as 6 characters including lower-case, upper-case, numbers and symbols.';
        }
        return $errors;
    }
}