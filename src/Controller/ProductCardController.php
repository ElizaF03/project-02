<?php

namespace Controller;

use Model\Product;
use Model\Review;

class ProductCardController
{

    public function getProductCard()
    {
        session_start();
        $productModel = new Product();
        $review = new Review();
        $reviews=$review->getByProductId($_POST['id-product']);
        $product=$productModel->getById($_POST['id-product']);
        require_once '../View/product-card.php';
    }
}