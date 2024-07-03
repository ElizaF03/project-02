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
    private ImageRepository $imageRepository;

    public function __construct(AuthenticationInterface $authenticationService, CartService $cartService, RatingService $ratingService, ReviewRepository $reviewRepository, OrderRepository $orderRepository, ProductRepository $productRepository, OrderProductRepository $orderProductRepository, ImageRepository $imageRepository)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
        $this->ratingService = $ratingService;
        $this->reviewRepository = $reviewRepository;
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->orderProductRepository = $orderProductRepository;
        $this->imageRepository = $imageRepository;
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
            foreach ($orders as $order) {
                $orderId = $order->getId();
                $productFromOrder = $this->orderProductRepository->getOne($orderId, $productId);

                if ($productFromOrder !== null && !$review) {
                    $grade = $request->getGrade();
                    $reviewText = $request->getReview();
                    $this->reviewRepository->create($userId, $productId, $grade, $reviewText);
                }
            }
            $file = $_FILES['img'];
            $name = mt_rand(0, 1000) . $file['name'];
            $path = './../Storage/Files/' . $name;
            if (isset($file)) {
                $this->uploadImg($file, $name);
            }
            $review = $this->reviewRepository->getOne($userId, $productId);
            $reviewId = $review->getId();
            $this->imageRepository->create($productId, $reviewId, $path);
        }
        $reviews = $this->reviewRepository->getByProductId($productId);
        $rating = $this->ratingService->calcRating($reviews);
        $product = $this->productRepository->getById($productId);
        $sum = $this->cartService->getTotalQuantity($userId);
        $img=$this->imageRepository->getOne($productId,$review->getId());
        $path= $img->getPath();
        require_once '../View/product-card.php';
    }

    public function uploadImg($file, $name)
    {
        copy($file['tmp_name'], './../Storage/Files/' . $name);
    }
}