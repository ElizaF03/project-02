<?php

namespace Controller;

use Model\Product;
use Model\UserProduct;

class ProductController
{
    public function getCatalog()
    {
        session_start();
        $products = Product::getAll();

        if (!isset($_SESSION['user_id'])) {
            $sum = 0;
        } else {
            $sum = $this->getTotalQuantity($_SESSION['user_id']);

        }
        require_once '../View/catalog.php';
    }

    public function getProductCard()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            $sum = 0;
        } else {
            $sum = $this->getTotalQuantity($_SESSION['user_id']);
        }
        $product = Product::getById($_POST['id-product']);
        require_once '../View/product-card.php';
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