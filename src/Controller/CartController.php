<?php


class CartController
{
    public function getCart(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $userProductController = new UserProductController();
            $products=$userProductController->getUserProducts($_SESSION['user_id'], UserProduct::class);
            require_once './../View/cart.php';
        }
    }
    public function getTotalQuantity($userId): int
    {
        $userProduct = new UserProduct();
        $userProducts = $userProduct->getAllByUserId($_SESSION['user_id']);
        $sum = 0;
        foreach ($userProducts as $userProduct) {
            $sum += $userProduct['quantity'];
        }
        return $sum;
    }

    public function addProduct(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $productId = $_POST['id-product'];
            $userId = $_SESSION['user_id'];
            $userProduct = new UserProduct();
            $oneUserProduct = $userProduct->getOne($userId, $productId);
            if (!$oneUserProduct) {
                $userProduct->create($userId, $productId);
            } else {
                $userProduct->plusQuantity($userId, $productId);
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
            $userProduct = new UserProduct();
            $oneUserProduct = $userProduct->getOne($userId, $productId);
            if ($oneUserProduct) {
                if ($oneUserProduct['quantity'] === 1) {
                    $userProduct->remove($userId, $productId);
                } else {
                    $userProduct->minusQuantity($userId, $productId);
                }
            }
            header('Location: /catalog');
        }
    }
}