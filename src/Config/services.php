<?php

use Controller\CartController;
use Controller\FavoriteController;
use Controller\OrderController;
use Controller\ProductCardController;
use Controller\ProductController;
use Controller\ReviewController;
use Controller\UserController;

return [
    CartController::class => function () {
        $authService = new \Service\AuthenticationSessionService();
        $cartService = new \Service\CartService();
        $userProductRepository=new \Repository\UserProductRepository();
        $object = new CartController($authService, $cartService, $userProductRepository);
        return $object;
    },
    FavoriteController::class => function () {
        $authService = new \Service\AuthenticationSessionService();
        $cartService = new \Service\CartService();
        $favoriteRepository=new \Repository\FavoriteRepository();
        $object = new \Controller\FavoriteController($authService, $cartService, $favoriteRepository);
        return $object;
    },
    OrderController::class => function () {
        $authService = new \Service\AuthenticationSessionService();
        $cartService = new \Service\CartService();
        $orderService = new \Service\OrderService();
        $userProductRepository=new \Repository\UserProductRepository();
        $object = new \Controller\OrderController($authService, $cartService, $orderService, $userProductRepository);
        return $object;
    },
    ReviewController::class => function () {
        $authService = new \Service\AuthenticationSessionService();
        $cartService = new \Service\CartService();
        $object = new \Controller\ReviewController($authService, $cartService);
        return $object;
    },
    UserController::class => function () {
        $authService = new \Service\AuthenticationSessionService();
        $object = new \Controller\UserController($authService);
        return $object;
    },
    ProductController::class => function () {
        $authService = new \Service\AuthenticationSessionService();
        $cartService = new \Service\CartService();
        $productRepository=new \Repository\ProductRepository();
        $object = new \Controller\ProductController($authService, $cartService, $productRepository);
        return $object;
    },
    ProductCardController::class => function () {
        $authService = new \Service\AuthenticationSessionService();
        $cartService = new \Service\CartService();
        $productRepository=new \Repository\ProductRepository();
        $object = new \Controller\ProductCardController($authService, $cartService, $productRepository);
        return $object;
    },
];