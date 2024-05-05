<?php

class ProductController
{
    public function getCatalog()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $productModel = new Product();
            $products = $productModel->getAll();
            $cartController = new CartController();
            $sum=$cartController->getTotalQuantity($_SESSION['user_id']);
            require_once '../View/catalog.php';
        }
    }
}