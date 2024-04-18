<?php
require_once '../Model/User.php';
require_once '../Controller/UserController.php';

if(isset($_POST['name'])){
    $username = $_POST['name'];
}
if(isset($_POST['email'])){
    $email = $_POST['email'];
}
if(isset($_POST['password'])){
    $password = $_POST['password'];
}
if(isset($_POST['repeat-password'])){
    $pswRepeat = $_POST['repeat-password'];
}
$user = new User();
$userController = new UserController();
$userController->validateRegistration($username, $email, $password, $pswRepeat);
if(empty($errors)){

    $user->registration($username, $email, $password);
}

 require_once './get_registration.php';
