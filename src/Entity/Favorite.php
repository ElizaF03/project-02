<?php

namespace Entity;

use Repository\ProductRepository;

class Favorite
{
    private int $id;
    private User $user;
    private Product $product;



    public function __construct(int $id, User $user, Product $product)
    {
        $this->id = $id;
        $this->user = $user;
        $this->product = $product;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}