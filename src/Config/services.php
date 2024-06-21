<?php

use Controller\CartController;
use Controller\FavoriteController;
use Controller\OrderController;
use Controller\ProductCardController;
use Controller\ProductController;
use Controller\ReviewController;
use Controller\UserController;
use Repository\FavoriteRepository;
use Repository\ProductRepository;
use Repository\ReviewRepository;
use Repository\UserProductRepository;
use Repository\UserRepository;
use Service\AuthenticationSessionService;
use Service\CartService;
use Service\OrderService;

return [
    CartController::class => function (Container $container) {
        $authService = new AuthenticationSessionService();
        $userProductRepository = $container->get(UserProductRepository::class);
        $cartService = $container->get(CartService::class);
        return new CartController($authService, $cartService, $userProductRepository);
    },
    FavoriteController::class => function (Container $container) {
        $authService = new AuthenticationSessionService();
        $productRepository = new ProductRepository();
        $cartService = $container->get(CartService::class);
        $favoriteRepository = new FavoriteRepository($productRepository);
        return new \Controller\FavoriteController($authService, $cartService, $favoriteRepository);
    },
    OrderController::class => function (Container $container) {
        $authService = new AuthenticationSessionService();
        $userProductRepository = $container->get(UserProductRepository::class);
        $cartService = $container->get(CartService::class);
        $orderService = new OrderService();
        return new \Controller\OrderController($authService, $cartService, $orderService, $userProductRepository);
    },
    ReviewController::class => function (Container $container) {
        $authService = new AuthenticationSessionService();
        $productRepository = new ProductRepository();
        $cartService = $container->get(CartService::class);
        $reviewRepository = new ReviewRepository();
        return new \Controller\ReviewController($authService, $cartService, $reviewRepository, $productRepository);
    },
    UserController::class => function () {
        $authService = new AuthenticationSessionService();
        $userRepository = new UserRepository();
        return new \Controller\UserController($authService, $userRepository);
    },
    ProductCardController::class => function (Container $container) {
        $authService = new AuthenticationSessionService();
        $productRepository = new ProductRepository();
        $cartService = $container->get(CartService::class);
        return new \Controller\ProductCardController($authService, $cartService, $productRepository);
    },
    ProductController::class => function (Container $container) {
        $authService = new AuthenticationSessionService();
        $productRepository = new ProductRepository();
        $cartService = $container->get(CartService::class);
        return new ProductController($authService, $cartService, $productRepository);
    },
    CartService::class => function (Container $container) {
        $userProductRepository = $container->get(UserProductRepository::class);
        return new CartService($userProductRepository);
    },
    UserProductRepository::class => function () {
        $userRepository = new UserRepository();
        $productRepository = new ProductRepository();
        return new UserProductRepository($userRepository, $productRepository);
    },
];