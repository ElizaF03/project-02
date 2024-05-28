<?php

namespace Controller;

use DateTime;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;
use Request\OrderRequest;

class OrderController
{
    public function getOrder(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $userProducts = UserProduct::getAllByUserId($_SESSION['user_id']);
            $totalPrice = $this->calcTotalPrice($userProducts);
            require_once '../View/order.php';
        }
    }

    public function calcTotalPrice($products): float|int
    {
        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += $product->getQuantity() * $product->getProduct()->getPrice();
        }
        return $totalPrice;
    }



    public function makeOrder(OrderRequest $request): void
    {
        session_start();
        $errors = $request->validate();
        $userId = $_SESSION['user_id'];
        if (empty($errors)) {
            $firstName=$request->getFirstName();
            $lastName=$request->getLastName();
            $address=$request->getAddress();
            $phone=$request->getPhone();
            $totalPrice=$request->getTotalPrice();
            $date = new DateTime();
            $date = $date->format('Y-m-d H:i:s');
            Order::addInfo($userId, $firstName, $lastName, $address, $phone, $totalPrice, $date);
            $userProducts = UserProduct::getAllByUserId($userId);
            $order = Order::getOrder($userId);
            $orderId = $order->getId();
            foreach ($userProducts as $userProduct) {
                OrderProduct::create($orderId, $userProduct->getProduct()->getId(), $userProduct->getQuantity());
            }
            UserProduct::removeAll($userId);
            header('Location: /catalog');
        } else {
            $userProducts = UserProduct::getAllByUserId($userId);
            require_once '../View/order.php';
        }
    }

}