<?php

namespace Repository;

use Entity\Order;
use Entity\OrderProduct;

class OrderProductRepository extends Repository
{
    public function create(int $orderId, int $productId, int $quantity): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO order_products (order_id, product_id, quantity) VALUES(:order_id, :product_id, :quantity)');
        $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'quantity' => $quantity]);
    }
    public function getOne(int $orderId, int $productId): ?OrderProduct
    {
        $stmt = $this->pdo->prepare('SELECT * FROM order_products WHERE order_id = :order_id AND product_id = :product_id');
        $stmt->execute(['order_id' => $orderId, 'product_id' => $productId]);
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        }
        return $this->hydrate($result, $orderId);
    }

    private function hydrate(array $result, $orderId): OrderProduct
    {
        return new OrderProduct($result['id'], $orderId, $result['product_id'], $result['quantity']);
    }
}