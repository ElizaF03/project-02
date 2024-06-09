<?php

namespace Controller;

use Model\Product;
use Model\UserProduct;
use Service\AuthenticationInterface;
use Service\CartService;

class ProductController
{
    private AuthenticationInterface $authenticationService;
    private CartService $cartService;

    public function __construct(AuthenticationInterface $authenticationService, CartService $cartService)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
    }

    public function getCatalog()
    {
        $products = Product::getAll();
        $user = $this->authenticationService->getUser();
        if ($user === null) {
            $sum = 0;
        } else {
            $sum = $this->cartService->getTotalQuantity($user->getId());
        }
        require_once '../View/catalog.php';
    }

}