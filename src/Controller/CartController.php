<?php


class CartController
{
    public function getCart(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $products=$this->showUserProducts($_SESSION['user_id']);
            require_once './../View/cart.php';
        }
    }

    public function showUserProducts($userId): ?array
    {
        $userProduct = new UserProduct();
        $product = new Product();
        $userProducts = $userProduct->getAllByUserId($_SESSION['user_id']);
        $productIds = [];
        $products = [];
        foreach ($userProducts as $userProduct) {
            $productIds[] = $userProduct['product_id'];
        }
        foreach ($productIds as $productId) {
            $products[] = $product->getById($productId);
        }
        foreach ($products as &$product) {
            foreach ($userProducts as $userProduct) {
                if ($product['id'] === $userProduct['product_id']) {
                    $product['quantity'] = $userProduct['quantity'];
                }
            }
        }
        unset($product);
        return $products;
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