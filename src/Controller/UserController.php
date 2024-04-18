<?php
require_once '../Model/User.php';

class UserController
{
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
    public function validateRegistration(string $username, string $email, string $password, string $pswRepeat): array
    {
        $errors=[];
        if(strlen($username) < 2){
            $errors['name']='Name is too short';
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email']='Invalid email format';
        }else{
            $user = new User();
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
        return $errors;

    }
}