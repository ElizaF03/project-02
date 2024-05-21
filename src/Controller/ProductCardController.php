<?php

namespace Controller;

use Model\Product;
use Model\Review;

class ProductCardController
{

    public function getProductCard()
    {
        session_start();
        $reviews=Review::getByProductId($_POST['id-product']);
        $product=Product::getById($_POST['id-product']);
        if($reviews){
            $rating=$this->calcRating($reviews);
        }else{
            $rating='no ratings';
        }

        require_once '../View/product-card.php';
    }
    public function calcRating($reviews){
        $grades=[];
        foreach ($reviews as $review){
            $grades[]=$review->getGrade();
        }
        return array_sum($grades)/count($grades);
    }
}