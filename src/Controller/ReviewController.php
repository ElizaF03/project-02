<?php

namespace Controller;

use Repository\OrderProductRepository;
use Repository\OrderRepository;
use Repository\ProductRepository;
use Repository\ReviewRepository;
use Request\ReviewRequest;
use Service\AuthenticationInterface;
use Service\CartService;
use Service\RatingService;

class ReviewController
{
    private AuthenticationInterface $authenticationService;
    private CartService $cartService;
    private RatingService $ratingService;
    private ReviewRepository $reviewRepository;
    private OrderRepository $orderRepository;
    private ProductRepository $productRepository;
    private OrderProductRepository $orderProductRepository;

    public function __construct(AuthenticationInterface $authenticationService, CartService $cartService, RatingService $ratingService, ReviewRepository $reviewRepository, OrderRepository $orderRepository, ProductRepository $productRepository, OrderProductRepository $orderProductRepository)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
        $this->ratingService = $ratingService;
        $this->reviewRepository = $reviewRepository;
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->orderProductRepository = $orderProductRepository;
    }

    public function addReview(ReviewRequest $request)
    {
        $user = $this->authenticationService->getUser();
        if ($user === null) {
            header('Location: login');
        }
        $userId = $user->getId();
        $productId = $request->getProductId();
        $orders = $this->orderRepository->getAll($userId);
        if (!empty($orders)) {
            foreach ($orders as $order) {
                $orderId = $order->getId();
                $productFromOrder = $this->orderProductRepository->getOne($orderId, $productId);
                $review = $this->reviewRepository->getOne($userId, $productId);
                if ($productFromOrder !== null && !$review) {
                    $grade = $request->getGrade();
                    $reviewText = $request->getReview();
                    $this->reviewRepository->create($userId, $productId, $grade, $reviewText);
                }
            }
        }
        $reviews = $this->reviewRepository->getByProductId($productId);
        $rating = $this->ratingService->calcRating($reviews);
        $product = $this->productRepository->getById($productId);
        $sum = $this->cartService->getTotalQuantity($userId);
        require_once '../View/product-card.php';
    }
}