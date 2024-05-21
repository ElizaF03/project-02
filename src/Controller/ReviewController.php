<?php

namespace Controller;

use Model\Product;
use Model\Review;

class ReviewController
{

    public function addReview()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $productId = $_POST['id-product'];
            $userId = $_SESSION['user_id'];
            $grade = $_POST['grade'];
            $reviewText = $_POST['review'];
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

    public function calcRating($reviews): float|int
    {
        $grades=[];
        foreach ($reviews as $review){
            $grades[]=$review['grade'];
        }
        return array_sum($grades)/count($grades);
    }
}