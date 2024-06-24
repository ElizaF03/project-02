<?php

namespace Controller;

use Model\Product;
use Model\UserProduct;
use Repository\ProductRepository;
use Service\AuthenticationInterface;
use Service\CartService;

class ProductController
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

    public function getCatalog()
    {
        $products =  $this->productRepository->getAll();
        $user = $this->authenticationService->getUser();
        if ($user === null) {
            $sum = 0;
        } else {
            $sum = $this->cartService->getTotalQuantity($user->getId());
        }
        require_once '../View/catalog.php';
    }

}