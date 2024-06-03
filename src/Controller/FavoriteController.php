<?php

namespace Controller;

use Model\FavoriteProduct;
use Model\UserProduct;
use Request\ProductRequest;
use Service\AuthenticationInterface;

class FavoriteController
{
    private AuthenticationInterface $authenticationService;

    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function getFavoriteProducts(): void
    {
        $user = $this->authenticationService->getUser();
        if ($user === null) {
            header('Location: login');
        }
        $products = FavoriteProduct::getAllByUserId($user->getId());
        $sum = $this->getTotalQuantity($user->getId());
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

    public function addFavoriteProduct(ProductRequest $request): void
    {
        $user = $this->authenticationService->getUser();
        if ($user === null) {
            header('Location: login');
        }
        $productId = $request->getProductId();
        $userId = $user->getId();
        $oneFavoriteProduct = FavoriteProduct::getOne($userId, $productId);
        if (!$oneFavoriteProduct) {
            FavoriteProduct::create($userId, $productId);
        }
        $products = FavoriteProduct::getAllByUserId($userId);
        $sum = $this->getTotalQuantity($userId);
        require_once './../View/favorites.php';
    }

    public function removeFavoriteProduct(ProductRequest $request): void
    {
        $user = $this->authenticationService->getUser();
        if ($user === null) {
            header('Location: login');
        }
        $productId = $request->getProductId();
        $userId = $user->getId();
        $oneFavoriteProduct = FavoriteProduct::getOne($userId, $productId);
        if ($oneFavoriteProduct) {
            FavoriteProduct::remove($userId, $productId);
        }
        $products = FavoriteProduct::getAllByUserId($userId);
        $sum = $this->getTotalQuantity($userId);
        require_once './../View/favorites.php';
    }
}