<?php

namespace Controller;

use Model\Product;
use Model\UserProduct;
use Request\ProductRequest;
use Service\AuthenticationService;

class ProductController
{
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
    }

    public function getCatalog()
    {
        session_start();
        $products = Product::getAll();
        if (!$this->authenticationService->check()) {
            $sum = 0;
        } else {
            $sum = $this->getTotalQuantity($_SESSION['user_id']);

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