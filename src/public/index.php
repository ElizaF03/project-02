<?php

use Controller\CartController;
use Controller\FavoriteController;
use Controller\OrderController;
use Controller\ProductCardController;
use Controller\ProductController;
use Controller\UserController;
use Controller\ReviewController;
use Request\LoginRequest;
use Request\RegistrationRequest;

require_once '../Autoloader.php';

$path = dirname(__DIR__);
Autoloader::registarte($path);


$app = new App();
$app->get('/login', UserController::class, 'getLogin');
$app->post('/login', UserController::class, 'login', LoginRequest::class);
$app->get('/registration', UserController::class, 'getRegistration');
$app->post('/registration', UserController::class, 'registration', RegistrationRequest::class);
$app->get('/logout', UserController::class, 'logout');
$app->get('/catalog', ProductController::class, 'getCatalog');
$app->post('/product-card', ProductCardController::class, 'getProductCard');
$app->post('/add-review', ReviewController::class, 'addReview');
$app->get('/add-product', ProductController::class, 'getCatalog');
$app->post('/add-product', CartController::class, 'addProduct');
$app->get('/remove-product', ProductController::class, 'getCatalog');
$app->post('/remove-product', CartController::class, 'removeProduct');
$app->get('/favorites', FavoriteController::class, 'getFavoriteProducts');
$app->post('/favorites', FavoriteController::class, 'addFavoriteProduct');
$app->post('/remove-favorite-product', FavoriteController::class, 'removeFavoriteProduct');
$app->get('/cart', CartController::class, 'getCart');
$app->post('/cart', OrderController::class, 'getOrder');
$app->post('/form-order', OrderController::class, 'getOrder');
$app->post('/order', OrderController::class, 'makeOrder');
$app->run();
