<?php

namespace Controller;

use Model\Product;
use Model\Review;
use Request\ReviewRequest;
use Service\AuthenticationInterface;

class ReviewController
{
    private AuthenticationInterface $authenticationService;

    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function addReview(ReviewRequest $request)
    {
        if (!$this->authenticationService->check()) {
            header('Location: login');
        }
        $userId = $this->authenticationService->getUser()->getId();
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