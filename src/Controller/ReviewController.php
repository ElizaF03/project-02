<?php

namespace Controller;

use Repository\ImageRepository;
use Repository\OrderProductRepository;
use Repository\OrderRepository;
use Repository\ProductRepository;
use Repository\ReviewRepository;
use Request\ReviewRequest;
use Service\AuthenticationInterface;
use Service\CartService;
use Service\ImageService;
use Service\OrderService;
use Service\RatingService;
use function Sodium\add;

class ReviewController
{
    private AuthenticationInterface $authenticationService;
    private CartService $cartService;
    private RatingService $ratingService;
    private ReviewRepository $reviewRepository;
    private OrderRepository $orderRepository;
    private ProductRepository $productRepository;
    private OrderProductRepository $orderProductRepository;

    private ImageService $imageService;
    private  OrderService  $orderService;

    public function __construct(AuthenticationInterface $authenticationService, CartService $cartService, RatingService $ratingService, ReviewRepository $reviewRepository, OrderRepository $orderRepository, ProductRepository $productRepository, OrderProductRepository $orderProductRepository, ImageService $imageService, OrderService  $orderService)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
        $this->ratingService = $ratingService;
        $this->reviewRepository = $reviewRepository;
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->orderProductRepository = $orderProductRepository;
        $this->imageService = $imageService;
        $this->orderService = $orderService;
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
        $review = $this->reviewRepository->getOne($userId, $productId);
        if (!empty($orders)) {
            $productFromOrder = $this->orderService->searchProductInOrders($orders, $productId);
            if ($productFromOrder && $review === null) {
                $grade = $request->getGrade();
                $reviewText = $request->getReview();
                $this->reviewRepository->create($userId, $productId, $grade, $reviewText);
            }
            $reviewId = $this->reviewRepository->getOne($userId, $productId)->getId();
            $this->imageService->addImage($productId, $reviewId);
        }
        $reviews = $this->reviewRepository->getByProductId($productId);
        foreach ($reviews as $review) {
            $reviewId=$review->getId();
            $img = $this->imageService->getImage($reviewId);
        }
        $rating = $this->ratingService->calcRating($reviews);
        $product = $this->productRepository->getById($productId);
        $sum = $this->cartService->getTotalQuantity($userId);
        require_once '../View/product-card.php';
    }

}