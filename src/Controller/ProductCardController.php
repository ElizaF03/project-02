<?php

namespace Controller;

use Repository\ProductRepository;
use Repository\ReviewRepository;
use Request\ProductRequest;
use Service\AuthenticationInterface;
use Service\CartService;
use Service\RatingService;

class ProductCardController
{

    private AuthenticationInterface $authenticationService;
    private CartService $cartService;
    private RatingService $ratingService;
    private ProductRepository $productRepository;
    private ReviewRepository $reviewRepository;

    public function __construct(AuthenticationInterface $authenticationService, CartService $cartService, RatingService $ratingService, ProductRepository $productRepository, ReviewRepository $reviewRepository)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
        $this->ratingService = $ratingService;
        $this->productRepository = $productRepository;
        $this->reviewRepository = $reviewRepository;
    }

    public function getProductCard(ProductRequest $request)
    {
        $reviews=$this->reviewRepository->getByProductId($request->getProductId());
        $product=$this->productRepository->getById($request->getProductId());
        $user = $this->authenticationService->getUser();
        if ($user === null) {
            $sum = 0;
        } else {
            $sum = $this->cartService->getTotalQuantity($user->getId());
        }
        if($reviews){
            $rating=$this->ratingService->calcRating($reviews);
        }else{
            $rating='no ratings';
        }
        require_once '../View/product-card.php';
    }
}