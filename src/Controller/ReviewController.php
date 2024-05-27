<?php

namespace Controller;

use Model\Product;
use Model\Review;
use Request\ReviewRequest;

class ReviewController
{

    public function addReview(ReviewRequest $request)
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $userId = $_SESSION['user_id'];
            $productId = $request->getProductId();
            $grade = $request->getGrade();
            $reviewText = $request->getReview();
            $review=Review::getOne($userId, $productId);
            if(!$review){
                Review::create($userId, $productId,$grade, $reviewText);
            }
            $reviews = Review::getByProductId($productId);
            $rating=$this->calcRating($reviews);
            $product = Product::getById($productId);
            require_once '../View/product-card.php';
        }

    }

    public function calcRating($reviews): float
    {
        $grades=[];
        foreach ($reviews as $review){
            $grades[]=$review->getGrade();
        }
        $numb=array_sum($grades)/count($grades);
        return round($numb,1);
    }
}