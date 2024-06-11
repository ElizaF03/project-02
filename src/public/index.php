<?php

use Controller\CartController;
use Controller\FavoriteController;
use Controller\OrderController;
use Controller\ProductCardController;
use Controller\ProductController;
use Controller\UserController;
use Controller\ReviewController;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\ProductRequest;
use Request\RegistrationRequest;
use Request\ReviewRequest;


require_once '../Autoloader.php';

$path = dirname(__DIR__);
Autoloader::registarte($path);

$container = new Container();
$app = new App($container);
$app->get('/login', UserController::class, 'getLogin');
$app->post('/login', UserController::class, 'login', LoginRequest::class);
$app->get('/registration', UserController::class, 'getRegistration');
$app->post('/registration', UserController::class, 'registration', RegistrationRequest::class);
$app->get('/logout', UserController::class, 'logout');
$app->get('/catalog', ProductController::class, 'getCatalog');
$app->post('/product-card', ProductCardController::class, 'getProductCard', ProductRequest::class);
$app->post('/add-review', ReviewController::class, 'addReview', ReviewRequest::class);
$app->get('/add-product', ProductController::class, 'getCatalog');
$app->post('/add-product', CartController::class, 'addProduct', ProductRequest::class);
$app->get('/remove-product', ProductController::class, 'getCatalog');
$app->post('/remove-product', CartController::class, 'removeProduct', ProductRequest::class);
$app->get('/favorites', FavoriteController::class, 'getFavoriteProducts');
$app->post('/favorites', FavoriteController::class, 'addFavoriteProduct', ProductRequest::class);
$app->post('/remove-favorite-product', FavoriteController::class, 'removeFavoriteProduct', ProductRequest::class);
$app->get('/cart', CartController::class, 'getCart');
$app->post('/cart', OrderController::class, 'getOrder');
$app->post('/form-order', OrderController::class, 'getOrder');
$app->post('/order', OrderController::class, 'makeOrder', OrderRequest::class);
$app->run();
