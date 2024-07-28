<?php

use Controller\CartController;
use Controller\FavoriteController;
use Controller\OrderController;
use Controller\ProductCardController;
use Controller\ProductController;
use Controller\ReviewController;
use Controller\UserController;
use Repository\FavoriteRepository;
use Repository\ImageRepository;
use Repository\OrderProductRepository;
use Repository\OrderRepository;
use Repository\ProductRepository;
use Repository\ReviewRepository;
use Repository\UserProductRepository;
use Repository\UserRepository;
use Service\AuthenticationInterface;
use Service\AuthenticationSessionService;
use Service\CartService;
use Service\ImageService;
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
        $productRepository = $container->get(ProductRepository::class);
        $cartService = $container->get(CartService::class);
        $ratingService = $container->get(RatingService::class);
        $orderRepository = $container->get(OrderRepository::class);
        $orderProductRepository = $container->get(OrderProductRepository::class);
        $reviewRepository = $container->get(ReviewRepository::class);
        $imageService = $container->get(ImageService::class);
        $orderService = $container->get(OrderService::class);
        return new ReviewController($authService, $cartService, $ratingService, $reviewRepository, $orderRepository, $productRepository, $orderProductRepository, $imageService, $orderService);
    },
    UserController::class => function () {
        global $container;
        $authService = $container->get(AuthenticationInterface::class);
        $userRepository = new UserRepository();
        return new UserController($authService, $userRepository);
    },
    ProductCardController::class => function (Container $container) {
        $authService = $container->get(AuthenticationInterface::class);
        $productRepository = $container->get(ProductRepository::class);
        $cartService = $container->get(CartService::class);
        $ratingService = $container->get(RatingService::class);
        $reviewRepository = $container->get(ReviewRepository::class);
        $orderRepository = $container->get(OrderRepository::class);
        $imageService = $container->get(ImageService::class);
        $orderService = $container->get(OrderService::class);
        return new ProductCardController($authService, $cartService, $ratingService, $productRepository, $reviewRepository, $orderRepository, $imageService, $orderService);
    },
    ProductController::class => function (Container $container) {
        $authService = $container->get(AuthenticationInterface::class);
        $productRepository = $container->get(ProductRepository::class);
        $cartService = $container->get(CartService::class);
        return new ProductController($authService, $cartService, $productRepository);
    },
    CartService::class => function (Container $container) {
        $userProductRepository = $container->get(UserProductRepository::class);
        return new CartService($userProductRepository);
    },
    OrderService::class => function (Container $container) {
        $orderRepository = $container->get(OrderRepository::class);
        $orderProductRepository = $container->get(OrderProductRepository::class);
        $userProductRepository = $container->get(UserProductRepository::class);
        $connection = $container->get(Connection::class);
        return new OrderService($orderRepository, $orderProductRepository, $userProductRepository, $connection);
    },
    RatingService::class => function () {
        return new RatingService();
    },
    ImageService::class => function (Container $container) {
        $imageRepository = $container->get(ImageRepository::class);
        return new ImageService($imageRepository);
    },
    AuthenticationInterface::class => function (Container $container) {
        $userRepository = $container->get(UserRepository::class);
        return new AuthenticationSessionService($userRepository);
    },
    ProductRepository::class => function (Container $container) {
        $connection = $container->get(Connection::class);
        return new ProductRepository($connection);
    },
    UserRepository::class=>function (Container $container) {
        $connection = $container->get(Connection::class);
        return new UserRepository($connection);
    },
    UserProductRepository::class => function (Container $container) {
        $userRepository = $container->get(UserRepository::class);
        $productRepository = $container->get(ProductRepository::class);
        $connection=$container->get(Connection::class);
        return new UserProductRepository($userRepository, $productRepository, $connection);
    },
    FavoriteRepository::class => function (Container $container) {
        $productRepository = $container->get(ProductRepository::class);
        $connection = $container->get(Connection::class);
        return new FavoriteRepository($productRepository, $connection);
    },
    OrderRepository::class => function (Container $container) {
        $connection = $container->get(Connection::class);
        return new OrderRepository($connection);
    },
    OrderProductRepository::class => function (Container $container) {
        $connection = $container->get(Connection::class);
        return new OrderProductRepository($connection);
    },
    ReviewRepository::class => function (Container $container) {
        $image = $container->get(ImageRepository::class);
        $connection = $container->get(Connection::class);
        return new ReviewRepository($connection, $image);
    },

    ImageRepository::class => function (Container $container) {
    $connection = $container->get(Connection::class);
        return new ImageRepository($connection);
    },

    Connection::class => function () {
        return new Connection();
    }
];