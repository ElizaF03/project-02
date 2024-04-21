<?php
require_once '../Model/User.php';

class UserController
{
    public function getRegistration(): void
    {
        require_once '../View/get_registration.php';
    }

    public function validateRegistration($username, $email, $password, $pswRepeat)
    {
        $errors = [];
        if (strlen($username) < 2) {
            $errors['name'] = 'Name is too short';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }
        $user = new User();
        $user=$user->getUserByEmail($email);
        if ($user['email'] === $_POST['email']) {
            $errors['email'] = 'Email already exists';
        }
        if (preg_match("/^[a-zA-Z0-9]+$/", $password) || strlen($password) < 6) {
            $errors['password'] = 'Password must contain as many as 6 characters including lower-case, upper-case, numbers and symbols.';
        }

        if ($pswRepeat != $password) {
            $errors['pswRepeat'] = 'Errors matching password';
        }
        return $errors;
    }

    public function registration(): void
    {
        if (isset($_POST['name'])) {
            $username = $_POST['name'];
        }
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
        }
        if (isset($_POST['password'])) {
            $password = $_POST['password'];
        }
        if (isset($_POST['repeat-password'])) {
            $pswRepeat = $_POST['repeat-password'];
        }
        $errors = $this->validateRegistration($username, $email, $password, $pswRepeat);
        if (empty($errors)) {
            {
                $user = new User();
                $user->addInfo($username, $email, $password);
            }
        }
        require_once '../View/get_registration.php';
    }

    public function getLogin(): void
    {
        require_once '../View/get_login.php';
    }

    public function validateLogin(string $email, string $password): array
    {
        $errors = [];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }
        if (preg_match("/^[a-zA-Z0-9]+$/", $password) || strlen($password) < 6) {
            $errors['password'] = 'Password must contain as many as 6 characters including lower-case, upper-case, numbers and symbols.';
        }
        return $errors;
    }

    public function login(): void
    {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
        }
        if (isset($_POST['password'])) {
            $password = $_POST['password'];
        }
        $errors = $this->validateLogin($email, $password);
        if (empty($errors)) {
            $user = new User();
            $user = $user->getUserByEmail($email);
            if ($user) {
                if (password_verify($password, $user['password'])) {
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
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