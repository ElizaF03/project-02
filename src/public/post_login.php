<?php
require_once '../Model/User.php';
require_once '../Controller/UserController.php';
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}
if (isset($_POST['password'])) {
    $password = $_POST['password'];
}
$user = new User();
$userController = new UserController();

if (empty($userController->validateLogin($email, $password))) {
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

