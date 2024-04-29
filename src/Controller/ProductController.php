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
            require_once '../View/catalog.php';
        }
    }
}