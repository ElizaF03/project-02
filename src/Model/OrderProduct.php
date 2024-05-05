<?php

class OrderProduct extends Model
{
    public function create(int $orderId, int $productId, int $quantity): void
    {
        $stmt = $this->getPdo()->prepare('INSERT INTO order_products (order_id, product_id, quantity) VALUES(:order_id, :product_id, :quantity)');
        $stmt->execute(array('order_id' => $orderId, 'product_id' => $productId, 'quantity' => $quantity));
    }
}