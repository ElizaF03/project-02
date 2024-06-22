<?php

use Controller\CartController;
use Controller\FavoriteController;
use Controller\OrderController;
use Controller\ProductCardController;
use Controller\ProductController;
use Controller\ReviewController;
use Controller\UserController;
use Repository\FavoriteRepository;
use Repository\OrderProductRepository;
use Repository\OrderRepository;
use Repository\ProductRepository;
use Repository\Repository;
use Repository\ReviewRepository;
use Repository\UserProductRepository;
use Repository\UserRepository;
use Service\AuthenticationSessionService;
use Service\CartService;
use Service\OrderService;

return [
    CartController::class => function (Container $container) {
        $authService = $container->get(AuthenticationSessionService::class);
        $userProductRepository = $container->get(UserProductRepository::class);
        $cartService = $container->get(CartService::class);
        return new CartController($authService, $cartService, $userProductRepository);
    },
    FavoriteController::class => function (Container $container) {
        $authService = $container->get(AuthenticationSessionService::class);
        $cartService = $container->get(CartService::class);
        $favoriteRepository = $container->get(FavoriteRepository::class);
        return new FavoriteController($authService, $cartService, $favoriteRepository);
    },
    OrderController::class => function (Container $container) {
        $authService = $container->get(AuthenticationSessionService::class);
        $userProductRepository = $container->get(UserProductRepository::class);
        $cartService = $container->get(CartService::class);
        $orderService = $container->get(OrderService::class);
        return new OrderController($authService, $cartService, $orderService, $userProductRepository);
    },
    ReviewController::class => function (Container $container) {
        $authService = $container->get(AuthenticationSessionService::class);
        $productRepository = new ProductRepository();
        $cartService = $container->get(CartService::class);
        $reviewRepository = new ReviewRepository();
        return new ReviewController($authService, $cartService, $reviewRepository, $productRepository);
    },
    UserController::class => function () {
        global $container;
        $authService = $container->get(AuthenticationSessionService::class);
        $userRepository = new UserRepository();
        return new UserController($authService, $userRepository);
    },
    ProductCardController::class => function (Container $container) {
        $authService = $container->get(AuthenticationSessionService::class);
        $productRepository = new ProductRepository();
        $cartService = $container->get(CartService::class);
        return new ProductCardController($authService, $cartService, $productRepository);
    },
    ProductController::class => function (Container $container) {
        $authService = $container->get(AuthenticationSessionService::class);
        $productRepository = new ProductRepository();
        $cartService = $container->get(CartService::class);
        return new ProductController($authService, $cartService, $productRepository);
    },
    CartService::class => function (Container $container) {
        $userProductRepository = $container->get(UserProductRepository::class);
        return new CartService($userProductRepository);
    },
    OrderService::class => function (Container $container) {
        $orderRepository = new OrderRepository();
        $orderProductRepository = new orderProductRepository();
        $repository = new Repository();
        $userProductRepository = $container->get(UserProductRepository::class);
        return new OrderService($orderRepository, $orderProductRepository, $userProductRepository, $repository);
    },
    AuthenticationSessionService::class => function (Container $container) {
        $userRepository = new UserRepository();
        return new AuthenticationSessionService($userRepository);
    },
    UserProductRepository::class => function () {
        $userRepository = new UserRepository();
        $productRepository = new ProductRepository();
        return new UserProductRepository($userRepository, $productRepository);
    },
    FavoriteRepository::class => function () {
        $productRepository = new ProductRepository();
        return new FavoriteRepository($productRepository);
    },

];