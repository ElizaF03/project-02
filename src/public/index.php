<?php
require_once '../Controller/UserController.php';
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];
$userController = new UserController();
$user = new User();
if ($requestUri === '/login') {
    if ($requestMethod === 'GET') {
        $userController->getLogin();
    } elseif ($requestMethod === 'POST') {
        $userController->login();
    } else {
        echo "Для адреса $requestUri метод $requestMethod не поддерживается";
    }
} elseif ($requestUri === '/registration') {
    if ($requestMethod === 'GET') {
        $userController->getRegistration();
    } elseif ($requestMethod === 'POST') {
        $userController->registration();
    } else {
        echo "Для адреса $requestUri метод $requestMethod не поддерживается";
    }
} elseif ($requestUri === '/catalog') {
    require_once '../View/catalog.php';
} elseif ($requestUri === '/logout') {
    require_once '../View/logout.php';
} elseif ($requestUri === '/cart') {
    require_once '../View/cart.html';
} else {
    require_once '../View/404.html';
}