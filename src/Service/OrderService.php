<?php

namespace Service;

use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;

class OrderService
{

    public  function createOrder(int $userId, array $data)
    {
        Order::addInfo($userId, $data['first-name'], $data['last-name'], $data['address'], $data['phone'], $data['total_price'], $data['date']);
        $userProducts = UserProduct::getAllByUserId($userId);
        $order = Order::getOrder($userId);
        $orderId = $order->getUserId();
        foreach ($userProducts as $userProduct) {
            OrderProduct::create($orderId, $userProduct->getProduct()->getId(), $userProduct->getQuantity());
        }
        UserProduct::removeAll($userId);
    }
}