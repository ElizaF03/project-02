<?php
require_once '../Model/User.php';

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
$errors=[];
if(strlen($username) < 2){
    $errors['name']='Name is too short';
}
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email']='Invalid email format';
}else{
    if($user->getUserByEmail($email)){
        $errors['email']='Email already exists';
    }
if(preg_match("/^[a-zA-Z0-9]+$/", $password) || strlen($password) < 6){
    $errors['password']='Password must contain as many as 6 characters including lower-case, upper-case, numbers and symbols.';
}
}
if($pswRepeat != $password){
    $errors['pswRepeat']='Errors matching password';
}
if(empty($errors)){

    $user->registration($username, $email, $password);
}

 require_once './get_registration.php';
