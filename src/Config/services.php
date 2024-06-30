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
use Service\AuthenticationInterface;
use Service\AuthenticationSessionService;
use Service\CartService;
use Service\OrderService;
use Service\RatingService;

return [
    CartController::class => function (Container $container) {
        $authService = $container->get(AuthenticationInterface::class);
        $userProductRepository = $container->get(UserProductRepository::class);
        $cartService = $container->get(CartService::class);
        return new CartController($authService, $cartService, $userProductRepository);
    },
    FavoriteController::class => function (Container $container) {
        $authService = $container->get(AuthenticationInterface::class);
        $cartService = $container->get(CartService::class);
        $favoriteRepository = $container->get(FavoriteRepository::class);
        return new FavoriteController($authService, $cartService, $favoriteRepository);
    },
    OrderController::class => function (Container $container) {
        $authService = $container->get(AuthenticationInterface::class);
        $userProductRepository = $container->get(UserProductRepository::class);
        $cartService = $container->get(CartService::class);
        $orderService = $container->get(OrderService::class);
        return new OrderController($authService, $cartService, $orderService, $userProductRepository);
    },
    ReviewController::class => function (Container $container) {
        $authService = $container->get(AuthenticationInterface::class);
        $productRepository = new ProductRepository();
        $cartService = $container->get(CartService::class);
        $ratingService = $container->get(RatingService::class);
        $orderRepository = $container->get(OrderRepository::class);
        $orderProductRepository = $container->get(OrderProductRepository::class);
        $reviewRepository = $container->get(ReviewRepository::class);
        return new ReviewController($authService, $cartService, $ratingService, $reviewRepository, $orderRepository, $productRepository, $orderProductRepository);
    },
    UserController::class => function () {
        global $container;
        $authService = $container->get(AuthenticationInterface::class);
        $userRepository = new UserRepository();
        return new UserController($authService, $userRepository);
    },
    ProductCardController::class => function (Container $container) {
        $authService = $container->get(AuthenticationInterface::class);
        $productRepository = new ProductRepository();
        $cartService = $container->get(CartService::class);
        $ratingService = $container->get(RatingService::class);
        $reviewRepository = $container->get(ReviewRepository::class);
        return new ProductCardController($authService, $cartService, $ratingService, $productRepository, $reviewRepository);
    },
    ProductController::class => function (Container $container) {
        $authService = $container->get(AuthenticationInterface::class);
        $productRepository = new ProductRepository();
        $cartService = $container->get(CartService::class);
        return new ProductController($authService, $cartService, $productRepository);
    },
    CartService::class => function (Container $container) {
        $userProductRepository = $container->get(UserProductRepository::class);
        return new CartService($userProductRepository);
    },
    OrderService::class => function (Container $container) {
        $orderRepository = $container->get(OrderRepository::class);
        $orderProductRepository = new orderProductRepository();
        $repository = new Repository();
        $userProductRepository = $container->get(UserProductRepository::class);
        return new OrderService($orderRepository, $orderProductRepository, $userProductRepository, $repository);
    },
    RatingService::class=>function () {
    return new RatingService();
    },
    AuthenticationInterface::class=>function (Container $container) {
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
    OrderRepository::class => function () {
        return new OrderRepository();
    },
    OrderProductRepository::class => function (Container $container) {
        return new OrderProductRepository();
    },
    ReviewRepository::class => function (Container $container) {
        return new ReviewRepository();
    },
    PDO::class => function () {
        $host = getenv('DB_HOST');
        $db = getenv('DB_NAME');
        $port = getenv('DB_PORT');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');
        return new PDO("pgsql:host=$host;port=$port;dbname=$db", "$user", "$password");
    },
];