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
            $reviewText = $_POST['review'];
            $reviewModel = new Review();
            $review=$reviewModel->getOne($userId, $productId);
            if(!isset($review)){
                $reviewModel->create($userId, $productId, $reviewText);
            }
            $reviews = $reviewModel->getByProductId($productId);
            $productModel = new Product();
            $product = $productModel->getById($_POST['id-product']);

            require_once '../View/product-card.php';
        }

    }
}