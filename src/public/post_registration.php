<?php



$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$pswRepeat = $_POST['repeat-password'];

$errors=[];
if(strlen($name) < 2){
    $errors['name']='Name is too short';
}
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors['email']='Invalid email format';
}
if(preg_match("/^[a-zA-Z0-9]+$/", $password) || strlen($password) < 6){
    $errors['password']='Password must contain as many as 6 characters including lower-case, upper-case, numbers and symbols.';
}
if($pswRepeat != $password){
    $errors['pswRepeat']='Errors matching password';
}
if(empty($errors)){
    $pdo = new PDO('pgsql:host=db;port=5432;dbname=dbname', 'dbuser', 'dbpwd');
    $password=password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO users (name, email, password) VALUES(:name, :email, :password)');
    $stmt->execute(array('name' => $name, 'email' => $email, 'password' => $password));
}

 require_once './get_registration.php';
