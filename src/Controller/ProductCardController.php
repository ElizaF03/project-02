<?php

namespace Controller;

use Model\Product;
use Model\Review;
use Request\ProductRequest;

class ProductCardController
{

    public function getProductCard(ProductRequest $request)
    {
        session_start();
        $reviews=Review::getByProductId($request->getProductId());
        $product=Product::getById($request->getProductId());
        if($reviews){
            $rating=$this->calcRating($reviews);
        }else{
            $rating='no ratings';
        }

        require_once '../View/product-card.php';
    }
    public function calcRating($reviews): float|int
    {
        $grades=[];
        foreach ($reviews as $review){
            $grades[]=$review->getGrade();
        }
        return array_sum($grades)/count($grades);
    }
}