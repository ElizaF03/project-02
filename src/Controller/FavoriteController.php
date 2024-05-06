<?php

class FavoriteController
{
    public function getFavoriteProducts(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $userProductController = new UserProductController();
            $products = $userProductController->getUserProducts($_SESSION['user_id'], FavoriteProduct::class);
            require_once './../View/favorites.php';
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
        $userProductController = new UserProductController();
        $products = $userProductController->getUserProducts($_SESSION['user_id'], FavoriteProduct::class);
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
        $userProductController = new UserProductController();
        $products = $userProductController->getUserProducts($_SESSION['user_id'], FavoriteProduct::class);
        require_once './../View/favorites.php';
    }
}