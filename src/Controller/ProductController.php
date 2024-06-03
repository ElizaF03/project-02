<?php

namespace Controller;

use Model\Product;
use Model\UserProduct;
use Service\AuthenticationInterface;

class ProductController
{
    private AuthenticationInterface $authenticationService;


    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function getCatalog()
    {
        $products = Product::getAll();
        if (!$this->authenticationService->check()) {
            $sum = 0;
        } else {
            $sum = $this->getTotalQuantity($this->authenticationService->getUser()->getId());
        }
        require_once '../View/catalog.php';
    }

    public function getTotalQuantity(int $userId): int
    {
        $userProducts = UserProduct::getAllByUserId($userId);
        $sum = 0;
        foreach ($userProducts as $userProduct) {
            $sum += $userProduct->getQuantity();
        }
        return $sum;
    }
}