<?php

namespace Entity;

use Repository\ProductRepository;
use Repository\UserRepository;

class UserProduct
{
    private int $id;
    private UserRepository $user;

    private ProductRepository $product;
    private int $quantity;
    public function __construct(int $id, UserRepository $user, ProductRepository $product, int $quantity)
    {
        $this->id = $id;
        $this->user = $user;
        $this->product = $product;
        $this->quantity = $quantity;
    }
    public function getId():int {
        return $this->id;
    }
    public function getUser():UserRepository{
        return $this->user;
    }
    public function getProduct():ProductRepository{
        return $this->product;
    }
    public function getQuantity():int{
        return $this->quantity;
    }
}