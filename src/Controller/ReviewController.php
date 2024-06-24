<?php

namespace Controller;

use Model\Product;
use Model\Review;
use Repository\ProductRepository;
use Repository\ReviewRepository;
use Request\ReviewRequest;
use Service\AuthenticationInterface;
use Service\CartService;

class ReviewController
{
    private AuthenticationInterface $authenticationService;
    private CartService $cartService;
    private ReviewRepository $reviewRepository;
    private ProductRepository $productRepository;

    public function __construct(AuthenticationInterface $authenticationService, CartService $cartService, ReviewRepository $reviewRepository, ProductRepository $productRepository)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
        $this->reviewRepository = $reviewRepository;
    }

    public function addReview(ReviewRequest $request)
    {
        $user = $this->authenticationService->getUser();
        if ($user === null) {
            header('Location: login');
        }
        $userId = $user->getId();
        $productId = $request->getProductId();
        $grade = $request->getGrade();
        $reviewText = $request->getReview();
        $review = $this->reviewRepository->getOne($userId, $productId);
        if (!$review) {
            $this->reviewRepository->create($userId, $productId, $grade, $reviewText);
        }
        $reviews = $this->reviewRepository->getByProductId($productId);
        $rating = $this->calcRating($reviews);
        $product = $this->productRepository->getById($productId);
        $sum=$this->cartService->getTotalQuantity($userId);
        require_once '../View/product-card.php';
    }


    public function calcRating($reviews): float
    {
        $grades = [];
        foreach ($reviews as $review) {
            $grades[] = $review->getGrade();
        }
        $numb = round(array_sum($grades) / count($grades), 1);
        return $numb;
    }
}