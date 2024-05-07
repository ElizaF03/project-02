<?php

namespace Controller;
use Model\FavoriteProduct;
use Model\Product;
use Model\UserProduct;

class FavoriteController
{
    public function getFavoriteProducts(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $products = $this->getUserProducts($_SESSION['user_id']);
            $sum=$this->getTotalQuantity($_SESSION['user_id']);
            require_once './../View/favorites.php';
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
    public function getUserProducts($userId): ?array
    {
        $favoriteProduct = new favoriteProduct();
        $product = new Product();
        $userProducts = $favoriteProduct->getAllByUserId($userId);
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
    public function addFavoriteProduct(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $productId = $_POST['id-product'];
            $userId = $_SESSION['user_id'];
            $favoriteProduct = new FavoriteProduct();
            $oneFavoriteProduct = $favoriteProduct->getOne($userId, $productId);
            if (!$oneFavoriteProduct) {
                $favoriteProduct->create($userId, $productId);
            }
        }
        $products = $this->getUserProducts($_SESSION['user_id']);
        $sum=$this->getTotalQuantity($_SESSION['user_id']);
        require_once './../View/favorites.php';
    }

    public function removeFavoriteProduct(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $productId = $_POST['id-product'];
            $userId = $_SESSION['user_id'];
            $favoriteProduct = new FavoriteProduct();
            $oneFavoriteProduct = $favoriteProduct->getOne($userId, $productId);
            if ($oneFavoriteProduct) {
                $favoriteProduct->remove($userId, $productId);
            }
        }
        $products = $this->getUserProducts($_SESSION['user_id']);
        $sum=$this->getTotalQuantity($_SESSION['user_id']);
        require_once './../View/favorites.php';
    }
}