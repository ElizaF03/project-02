<?php

namespace Controller;

use Repository\ImageRepository;
use Repository\OrderRepository;
use Repository\ProductRepository;
use Repository\ReviewRepository;
use Request\ProductRequest;
use Service\AuthenticationInterface;
use Service\CartService;
use Service\ImageService;
use Service\OrderService;
use Service\RatingService;
use Service\ReviewService;

class ProductCardController
{

    private AuthenticationInterface $authenticationService;
    private CartService $cartService;
    private RatingService $ratingService;
    private ProductRepository $productRepository;
    private ReviewRepository $reviewRepository;
    private OrderRepository $orderRepository;
    private OrderService $orderService;
    private ImageService $imageService;

    public function __construct(AuthenticationInterface $authenticationService, CartService $cartService, RatingService $ratingService, ProductRepository $productRepository, ReviewRepository $reviewRepository, OrderRepository $orderRepository, OrderService $orderService, ImageService $imageService)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
        $this->ratingService = $ratingService;
        $this->productRepository = $productRepository;
        $this->reviewRepository = $reviewRepository;
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
        $this->imageService = $imageService;
    }

    public function getProductCard(ProductRequest $request): void
    {
        $reviews = $this->reviewRepository->getByProductId($request->getProductId());
        $product = $this->productRepository->getById($request->getProductId());
        $user = $this->authenticationService->getUser();
        $userId = $user->getId();
        if ($user === null) {
            $sum = 0;
        } else {
            $sum = $this->cartService->getTotalQuantity($userId);
        }
        if ($reviews) {
            $rating = $this->ratingService->calcRating($reviews);
        }
        $getImage = function ($reviewId) {
        return $this->imageService->getImage($reviewId);
    };
        $orders = $this->orderRepository->getAll($userId);
        $productFromOrder = $this->orderService->searchProductInOrders($orders, $product->getId());
        require_once '../View/product-card.php';
    }
}