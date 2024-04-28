<?php
require_once '../Model/FavoriteProduct.php';
require_once '../Model/User.php';
require_once '../Model/Product.php';

class FavoriteController
{
    public function getFavoriteProducts(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $this->showFavoriteProducts($_SESSION['user_id']);
        }
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
        $this->showFavoriteProducts($_SESSION['user_id']);
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
        $this->showFavoriteProducts($_SESSION['user_id']);
    }

    public function showFavoriteProducts($userId): void
    {
        $favoriteProduct = new FavoriteProduct();
        $product = new Product();
        $favoriteProducts = $favoriteProduct->getAllByUserId($_SESSION['user_id']);
        $productIds = [];
        $products = [];
        foreach ($favoriteProducts as $favoriteProduct) {
            $productIds[] = $favoriteProduct['product_id'];
        }
        foreach ($productIds as $productId) {
            $products[] = $product->getById($productId);
        }

        require_once '../View/favorites.php';
    }
}