<?php

namespace Service;

class AuthenticationService
{
    public function check(): bool
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }
}