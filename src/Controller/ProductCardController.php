<?php

namespace Controller;

use Model\Product;
use Model\Review;
use Repository\ProductRepository;
use Request\ProductRequest;
use Service\AuthenticationInterface;
use Service\CartService;

class ProductCardController
{

    private AuthenticationInterface $authenticationService;
    private CartService $cartService;
    private ProductRepository $productRepository;

    public function __construct(AuthenticationInterface $authenticationService, CartService $cartService, ProductRepository $productRepository)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
        $this->productRepository = $productRepository;
    }

    public function getProductCard(ProductRequest $request)
    {
        $reviews=Review::getByProductId($request->getProductId());
        $product=$this->productRepository->getById($request->getProductId());
        $user = $this->authenticationService->getUser();
        if ($user === null) {
            $sum = 0;
        } else {
            $sum = $this->cartService->getTotalQuantity($user->getId());
        }
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