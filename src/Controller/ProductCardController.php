<?php

namespace Controller;

use Repository\ImageRepository;
use Repository\OrderRepository;
use Repository\ProductRepository;
use Repository\ReviewRepository;
use Request\ProductRequest;
use Service\AuthenticationInterface;
use Service\CartService;
use Service\ImageService;
use Service\OrderService;
use Service\RatingService;

class ProductCardController
{

    private AuthenticationInterface $authenticationService;
    private CartService $cartService;
    private RatingService $ratingService;
    private ProductRepository $productRepository;
    private ReviewRepository $reviewRepository;
    private OrderRepository $orderRepository;
    private ImageService $imageService;
    private OrderService $orderService;

    public function __construct(AuthenticationInterface $authenticationService, CartService $cartService, RatingService $ratingService, ProductRepository $productRepository, ReviewRepository $reviewRepository, OrderRepository $orderRepository, ImageService $imageService, OrderService $orderService)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
        $this->ratingService = $ratingService;
        $this->productRepository = $productRepository;
        $this->reviewRepository = $reviewRepository;
        $this->orderRepository = $orderRepository;
        $this->imageService = $imageService;
        $this->orderService = $orderService;
    }

    public function getProductCard(ProductRequest $request)
    {
        $reviews = $this->reviewRepository->getByProductId($request->getProductId());
        $product = $this->productRepository->getById($request->getProductId());
        $user = $this->authenticationService->getUser();
        foreach ($reviews as $review) {
                $reviewId=$review->getId();
                $img = $this->imageService->getImage($reviewId);
            if ($img) {
                $styleImg = "";
            } else {
                $styleImg = "style='display: none'";
            }  }


        if ($user === null) {
            $sum = 0;
        } else {
            $sum = $this->cartService->getTotalQuantity($user->getId());
        }
        if ($reviews) {
            $rating = $this->ratingService->calcRating($reviews);
        } else {
            $rating = 'no ratings';
        }
        $orders = $this->orderRepository->getAll($user->getId());
        $productFromOrder = $this->orderService->searchProductInOrders($orders, $product->getId());
        if ($productFromOrder) {
            $style = "";
        } else {
            $style = "style='display: none'";
        }
        require_once '../View/product-card.php';
    }
}