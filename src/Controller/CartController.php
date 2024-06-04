<?php

namespace Controller;

use Model\UserProduct;
use Request\ProductRequest;
use Service\AuthenticationInterface;
use Service\CartService;

class CartController
{
    private AuthenticationInterface $authenticationService;
    private CartService $cartService;

    public function __construct(AuthenticationInterface $authenticationService, CartService $cartService)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
    }

    public function getCart(): void
    {
        $user = $this->authenticationService->getUser();
        if ($user === null) {
            header('Location: login');
        }
        $userProducts = UserProduct::getAllByUserId($user->getId());
        $totalPrice = $this->cartService->calcTotalPrice($userProducts);
        require_once './../View/cart.php';
    }

    public function addProduct(ProductRequest $request): void
    {
        if (!$this->authenticationService->check()) {
            header('Location: login');
        }
        $productId = $request->getProductId();
        $userId = $this->authenticationService->getUser()->getId();
        $oneUserProduct = UserProduct::getOne($userId, $productId);
        if (!$oneUserProduct) {
            UserProduct::create($userId, $productId);
        } else {
            UserProduct::plusQuantity($userId, $productId);
        }
        header('Location: /catalog');
    }

    public function removeProduct(ProductRequest $request): void
    {
        if (!$this->authenticationService->check()) {
            header('Location: login');
        }
        $productId = $request->getProductId();
        $userId = $this->authenticationService->getUser()->getId();
        $oneUserProduct = UserProduct::getOne($userId, $productId);
        if ($oneUserProduct) {
            if ($oneUserProduct->getQuantity() === 1) {
                UserProduct::remove($userId, $productId);
            } else {
                UserProduct::minusQuantity($userId, $productId);
            }
        }
        header('Location: /catalog');
    }
}