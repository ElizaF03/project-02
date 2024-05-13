<?php

namespace Controller;
use Model\Product;
use Model\UserProduct;
class CartController
{
    public function getCart(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $products=$this->getUserProducts($_SESSION['user_id']);
            $totalPrice=$this->calcTotalPrice($products);
            require_once './../View/cart.php';
        }
    }
    public function getUserProducts($userId): ?array
    {
        $userProductModel = new userProduct();
        $product = new Product();
        $userProducts = $userProductModel->getAllByUserId($userId);
        $productIds = [];
        $products = [];
        foreach ($userProducts as $userProduct) {
            $productIds[] = $userProduct['product_id'];
        }
        foreach ($productIds as $productId) {
            $products[] = $product->getById($productId);
        }
        if(isset($userProduct['quantity']) ){
            foreach ($products as &$product) {
                foreach ($userProducts as $userProduct) {
                    if ($product['id'] === $userProduct['product_id']) {
                        $product['quantity'] = $userProduct['quantity'];
                    }
                }
            }
        }
        unset($product);
        return $products;
    }

    public function calcTotalPrice($products): float|int
    {
        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += $product['quantity'] * $product['price'];
        }
        return $totalPrice;
    }
    public function addProduct(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $productId = $_POST['id-product'];
            $userId = $_SESSION['user_id'];
            $userProduct = new UserProduct();
            $oneUserProduct = $userProduct->getOne($userId, $productId);
            if (!$oneUserProduct) {
                $userProduct->create($userId, $productId);
            } else {
                $userProduct->plusQuantity($userId, $productId);
            }
        }
        header('Location: /catalog');
    }

    public function removeProduct(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $productId = $_POST['id-product'];
            $userId = $_SESSION['user_id'];
            $userProduct = new UserProduct();
            $oneUserProduct = $userProduct->getOne($userId, $productId);
            if ($oneUserProduct) {
                if ($oneUserProduct['quantity'] === 1) {
                    $userProduct->remove($userId, $productId);
                } else {
                    $userProduct->minusQuantity($userId, $productId);
                }
            }
            header('Location: /catalog');
        }
    }
}