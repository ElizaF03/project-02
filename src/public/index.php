<?php
require_once '../Controller/UserController.php';
require_once '../Controller/ProductController.php';
require_once '../Controller/CartController.php';
require_once '../Controller/FavoriteController.php';
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];
$userController = new UserController();
$user = new User();
$productController = new ProductController();
$cartController = new CartController();
$favoriteController = new FavoriteController();
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
    $productController->getCatalog();
} elseif ($requestUri === '/logout') {
    require_once '../View/logout.php';
} elseif ($requestUri === '/cart') {
    if ($requestMethod === 'GET') {
        $cartController->getCart();
    } elseif ($requestMethod === 'POST') {
        $cartController->addProduct();
    } else {
        echo "Для адреса $requestUri метод $requestMethod не поддерживается";
    }
} elseif ($requestUri === '/favorites') {
    if ($requestMethod === 'GET') {
        $favoriteController->getFavoriteProducts();
    }elseif ($requestMethod === 'POST') {
        $favoriteController->addFavoriteProduct();
    } else {
        echo "Для адреса $requestUri метод $requestMethod не поддерживается";
    }
} else {
    require_once '../View/404.html';
}