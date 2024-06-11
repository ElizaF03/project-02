<?php

namespace Controller;

use Model\Product;
use Model\Review;
use Request\ReviewRequest;
use Service\AuthenticationInterface;
use Service\CartService;

class ReviewController
{
    private AuthenticationInterface $authenticationService;
    private CartService $cartService;

    public function __construct(AuthenticationInterface $authenticationService, CartService $cartService)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
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
        $review = Review::getOne($userId, $productId);
        if (!$review) {
            Review::create($userId, $productId, $grade, $reviewText);
        }
        $reviews = Review::getByProductId($productId);
        $rating = $this->calcRating($reviews);
        $product = Product::getById($productId);
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