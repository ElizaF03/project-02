<?php

namespace Controller;

use Model\Product;
use Model\UserProduct;
use Request\ProductRequest;
use Service\AuthenticationCookie;
use Service\AuthenticationService;

class ProductController
{
    private AuthenticationService $authenticationService;
    private AuthenticationCookie  $authenticationCookie;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
        $this->authenticationCookie = new AuthenticationCookie();
    }

    public function getCatalog()
    {
        $products = Product::getAll();
        if (!$this->authenticationCookie->check()) {
              $sum = 0;
        } else {
            $sum = $this->getTotalQuantity($this->authenticationCookie->getUser()->getId());
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