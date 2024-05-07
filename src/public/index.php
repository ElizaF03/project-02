<?php

use Controller\CartController;
use Controller\FavoriteController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;

require_once '../App.php';

$autoload = function (string $className) {
    $className = str_replace('\\', '/', $className);
    $path = "../$className.php";
    if (file_exists($path)) {
        require_once $path;
        return true;
    } else {
        return false;
    }
};

spl_autoload_register($autoload);

$app = new App();
$app->addRoute('/login', 'GET', UserController::class, 'getLogin');
$app->addRoute('/login', 'POST', UserController::class, 'login');
$app->addRoute('/registration', 'GET', UserController::class, 'getRegistration');
$app->addRoute('/registration', 'POST', UserController::class, 'registration');
$app->addRoute('/logout', 'GET', UserController::class, 'logout');
$app->addRoute('/catalog', 'GET', ProductController::class, 'getCatalog');
$app->addRoute('/add-product', 'GET', ProductController::class, 'getCatalog');
$app->addRoute('/add-product', 'POST', CartController::class, 'addProduct');
$app->addRoute('/remove-product', 'GET', ProductController::class, 'getCatalog');
$app->addRoute('/remove-product', 'POST', CartController::class, 'removeProduct');
$app->addRoute('/favorites', 'GET', FavoriteController::class, 'getFavoriteProducts');
$app->addRoute('/favorites', 'POST', FavoriteController::class, 'addFavoriteProduct');
$app->addRoute('/remove-favorite-product', 'POST', FavoriteController::class, 'removeFavoriteProduct');
$app->addRoute('/cart', 'GET', CartController::class, 'getCart');
$app->addRoute('/cart', 'POST', OrderController::class, 'getOrder');
$app->addRoute('/form-order', 'POST', OrderController::class, 'getOrder');
$app->addRoute('/order', 'POST', OrderController::class, 'makeOrder');
$app->run();
