<?php
namespace Controller;
use Model\Product;
use Model\UserProduct;

class ProductController
{
    public function getCatalog()
    {
        session_start();
        $productModel = new Product();
        $products = $productModel->getAll();

        if (!isset($_SESSION['user_id'])) {
            $sum=0;
        } else {
            $sum=$this->getTotalQuantity($_SESSION['user_id']);

        }require_once '../View/catalog.php';
    }
    public function getProductCard()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            $sum=0;
        }else{
            $sum=$this->getTotalQuantity($_SESSION['user_id']);
        }
        $productModel = new Product();
        $product=$productModel->getById($_POST['id-product']);
        require_once '../View/product-card.php';
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