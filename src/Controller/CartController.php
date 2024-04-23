<?php
require_once '../Model/UserProduct.php';
require_once '../Model/User.php';
require_once '../Model/Product.php';

class CartController
{
    public function getCart(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $this->showUserProducts($_SESSION['user_id']);
        }
    }

    public function showUserProducts($userId): void
    {
        $userProduct = new UserProduct();
        $product = new Product();
        $userProducts = $userProduct->getAllByUserId($_SESSION['user_id']);
        $productIds = [];
        $products = [];
        foreach ($userProducts as $userProduct) {
            $productIds[] = $userProduct['product_id'];
        }
        foreach ($productIds as $productId) {
            $products[] = $product->getById($productId);
        }

        require_once '../View/cart.php';
    }

    public function addProduct(): void
    {
        session_start();
        $userProduct = new UserProduct();

        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $productId = $_POST['id-product'];
            $userId = $_SESSION['user_id'];
            $oneUserProduct = $userProduct->getOne($userId, $productId);
            if (!$oneUserProduct) {
                $userProduct->create($userId, $productId);
            } else {
                $userProduct->add($userId, $productId);
            }
        }
        $this->showUserProducts($_SESSION['user_id']);

    }

}