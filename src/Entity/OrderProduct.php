<?php

namespace Entity;

use Repository\OrderProductRepository;

class OrderProduct extends OrderProductRepository
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $quantity;

    public function __construct(int $id, int $orderId, int $productId, int $quantity)
    {
        parent::__construct();
        $this->id = $id;
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}