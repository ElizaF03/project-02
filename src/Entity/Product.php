<?php

namespace Entity;

use Repository\ProductRepository;

class Product extends ProductRepository
{
    private int $id;
    private string $name;
    private float $price;
    private string $img_url;

    public function __construct(int $id, string $name, float $price, string $img_url)
    {
        parent::__construct();
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->img_url = $img_url;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getImgUrl(): string
    {
        return $this->img_url;
    }

}