<?php

namespace Controller;

use Model\FavoriteProduct;
use Model\UserProduct;
use Repository\FavoriteRepository;
use Request\ProductRequest;
use Service\AuthenticationInterface;
use Service\CartService;

class FavoriteController
{
    private AuthenticationInterface $authenticationService;
    private CartService $cartService;
    private FavoriteRepository $favoriteRepository;

    public function __construct(AuthenticationInterface $authenticationService, CartService $cartService, FavoriteRepository $favoriteRepository)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
        $this->favoriteRepository = $favoriteRepository;
    }

    public function getFavoriteProducts(): void
    {
        $user = $this->authenticationService->getUser();
        if ($user === null) {
            header('Location: login');
        }
        $products = $this->favoriteRepository->getAllByUserId($user->getId());
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
        $oneFavoriteProduct = $this->favoriteRepository->getOne($userId, $productId);
        if (!$oneFavoriteProduct) {
            FavoriteProduct::create($userId, $productId);
        }
        $products = $this->favoriteRepository->getAllByUserId($userId);
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
        $oneFavoriteProduct = $this->favoriteRepository->getOne($userId, $productId);
        if ($oneFavoriteProduct) {
            FavoriteProduct::remove($userId, $productId);
        }
        $products = $this->favoriteRepository->getAllByUserId($userId);
        $sum = $this->cartService->getTotalQuantity($userId);
        require_once './../View/favorites.php';
    }
}