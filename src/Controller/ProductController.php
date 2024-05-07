<?php
namespace Controller;
use Model\Product;
use Model\UserProduct;

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
            $sum=$this->getTotalQuantity($_SESSION['user_id']);
            require_once '../View/catalog.php';
        }
    }
    public function getTotalQuantity($userId): int
    {
        $userProduct = new UserProduct();
        $userProducts = $userProduct->getAllByUserId($userId);
        $sum = 0;
        foreach ($userProducts as $userProduct) {
            $sum += $userProduct['quantity'];
        }
        return $sum;
    }
}