<?php
require_once './User.php';
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
}


$errors = [];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Invalid email format';
}
if (preg_match("/^[a-zA-Z0-9]+$/", $password) || strlen($password) < 6) {
    $errors['password'] = 'Password must contain as many as 6 characters including lower-case, upper-case, numbers and symbols.';
}

if (empty($errors)) {
    $user = new User();
    $user = $user->getUserByEmail($email);
    if ($user) {
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header('Location: /catalog');
        } else {
            $incorrectPassword = 'Incorrect password';
        }
    } else {
        $noReg = 'User is not registered';
    }
}
require_once './get_login.php';

