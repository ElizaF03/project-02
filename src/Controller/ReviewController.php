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
            $reviewModel = new Review();
            $review=$reviewModel->getOne($userId, $productId);
            if(!$review){
                $reviewModel->create($userId, $productId,$grade, $reviewText);
            }
            $reviews = $reviewModel->getByProductId($productId);
            $rating=$this->calcRating($reviews);
            $product = Product::getById($_POST['id-product']);

            require_once '../View/product-card.php';
        }

    }

    public function calcRating($reviews){
        $grades=[];
        foreach ($reviews as $review){
            $grades[]=$review['grade'];
        }
        return array_sum($grades)/count($grades);
    }
}