<?php

namespace Controller;

use Model\Product;
use Model\UserProduct;
use Request\CartRequest;
use Request\ProductRequest;

class CartController
{
    public function getCart(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $userProducts = UserProduct::getAllByUserId($_SESSION['user_id']);
            $totalPrice = $this->calcTotalPrice($userProducts);
            require_once './../View/cart.php';
        }
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
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $productId = $request->getProductId();
            $userId = $_SESSION['user_id'];
            $oneUserProduct = UserProduct::getOne($userId, $productId);
            if (!$oneUserProduct) {
                UserProduct::create($userId, $productId);
            } else {
                UserProduct::plusQuantity($userId, $productId);
            }
        }
        header('Location: /catalog');
    }

    public function removeProduct(ProductRequest $request): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
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
}