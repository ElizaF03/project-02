<?php

namespace Controller;

use Model\FavoriteProduct;
use Model\Product;
use Model\UserProduct;
use Request\ProductRequest;
use Service\AuthenticationService;

class FavoriteController
{
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
    }

    public function getFavoriteProducts(): void
    {
        if (!$this->authenticationService->check()) {
            header('Location: login');
        }
        $products = FavoriteProduct::getAllByUserId($_SESSION['user_id']);
        $sum = $this->getTotalQuantity($_SESSION['user_id']);
        require_once './../View/favorites.php';
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

    public function getUserProducts($userId): ?array
    {
        return FavoriteProduct::getAllByUserId($userId);
    }

    public function addFavoriteProduct(ProductRequest $request): void
    {
        if (!$this->authenticationService->check()) {
            header('Location: login');
        }
        $productId = $request->getProductId();
        $userId = $_SESSION['user_id'];
        $oneFavoriteProduct = FavoriteProduct::getOne($userId, $productId);
        if (!$oneFavoriteProduct) {
            FavoriteProduct::create($userId, $productId);
        }
        $products = $this->getUserProducts($userId);
        $sum = $this->getTotalQuantity($userId);
        require_once './../View/favorites.php';
    }

    public function removeFavoriteProduct(ProductRequest $request): void
    {
        if (!$this->authenticationService->check()) {
            header('Location: login');
        }
        $productId = $request->getProductId();
        $userId = $_SESSION['user_id'];
        $oneFavoriteProduct = FavoriteProduct::getOne($userId, $productId);
        if ($oneFavoriteProduct) {
            FavoriteProduct::remove($userId, $productId);
        }
        $products = $this->getUserProducts($userId);
        $sum = $this->getTotalQuantity($userId);
        require_once './../View/favorites.php';
    }
}