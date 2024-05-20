<?php

namespace Controller;

use Model\Product;
use Model\UserProduct;

class CartController
{
    public function getCart(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $userProducts = $this->getUserProducts($_SESSION['user_id']);
            $totalPrice = $this->calcTotalPrice($userProducts);
            require_once './../View/cart.php';
        }
    }

    public function getUserProducts($userId): array
    {
        return UserProduct::getAllByUserId($userId);
    }

    public function calcTotalPrice($userProducts): float|int
    {
        $totalPrice = 0;
        foreach ($userProducts as $userProduct) {
            $totalPrice += $userProduct->getQuantity() * $userProduct->getProduct()->getPrice();
        }

        return $totalPrice;
    }

    public function addProduct(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $productId = $_POST['id-product'];
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

    public function removeProduct(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $productId = $_POST['id-product'];
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