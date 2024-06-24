<?php

namespace Entity;

use Repository\ProductRepository;

class Favorite
{
    private int $id;
    private int $userId;
    private ProductRepository $product;



    public function __construct(int $id, int $userId, ProductRepository $product)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->product = $product;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}