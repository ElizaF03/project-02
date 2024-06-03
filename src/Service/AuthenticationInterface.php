<?php

namespace Service;

use Model\User;

interface AuthenticationInterface
{
    public function authenticate(string $email, string $password): bool;

    public function logout();

    public function getUser(): ?User;

    public function check(): bool;

}