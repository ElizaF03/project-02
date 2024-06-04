<?php

namespace Controller;

use Model\FavoriteProduct;
use Model\UserProduct;
use Request\ProductRequest;
use Service\AuthenticationInterface;
use Service\CartService;

class FavoriteController
{
    private AuthenticationInterface $authenticationService;
    private CartService $cartService;

    public function __construct(AuthenticationInterface $authenticationService, CartService $cartService)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
    }

    public function getFavoriteProducts(): void
    {
        $user = $this->authenticationService->getUser();
        if ($user === null) {
            header('Location: login');
        }
        $products = FavoriteProduct::getAllByUserId($user->getId());
        $sum = $this->cartService->getTotalQuantity($user->getId());
        require_once './../View/favorites.php';
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
        $sum = $this->cartService->getTotalQuantity($userId);
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
        $sum = $this->cartService->getTotalQuantity($userId);
        require_once './../View/favorites.php';
    }
}