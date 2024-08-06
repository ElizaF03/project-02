<?php

namespace Repository;

use ConnectionInterface;
use Entity\OrderProduct;

class OrderProductRepository
{
    private ConnectionInterface $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function create(int $orderId, int $productId, int $quantity): void
    {
        $this->connection->execute('INSERT INTO order_products (order_id, product_id, quantity) VALUES(:order_id, :product_id, :quantity)', (['order_id' => $orderId, 'product_id' => $productId, 'quantity' => $quantity]));
    }

    public function getOne(int $orderId, int $productId): ?OrderProduct
    {
        $stmt = $this->connection->execute('SELECT * FROM order_products WHERE order_id = :order_id AND product_id = :product_id ', (['order_id' => $orderId, 'product_id' => $productId]));
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