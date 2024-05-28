<?php

namespace Controller;

use Model\Product;
use Model\UserProduct;
use Request\ProductRequest;
use Service\AuthenticationService;

class CartController
{
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
    }

    public function getCart(): void
    {
        if (!$this->authenticationService->check()) {
            header('Location: login');
        }
        $userProducts = UserProduct::getAllByUserId($_SESSION['user_id']);
        $totalPrice = $this->calcTotalPrice($userProducts);
        require_once './../View/cart.php';
    }


    public function calcTotalPrice($userProducts): float|int
    {
        $totalPrice = 0;
        foreach ($userProducts as $userProduct) {
            $totalPrice += $userProduct->getQuantity() * $userProduct->getProduct()->getPrice();
        }
        return $totalPrice;
    }

    public function addProduct(ProductRequest $request): void
    {
        if (!$this->authenticationService->check()) {
            header('Location: login');
        }
        $productId = $request->getProductId();
        $userId = $_SESSION['user_id'];
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
        $userId = $_SESSION['user_id'];
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