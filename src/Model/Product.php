<?php

namespace Model;
use AllowDynamicProperties;

#[AllowDynamicProperties] class Product extends Model
{
    private int $id;
    private string $name;
    private float $price;
    private string $img_url;



    public function __construct(int $id, string $name, float $price, string $img_url)
    {
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


    public static function getAll(): array
    {
        $stmt = self::getPdo()->query("SELECT * FROM products");
        $products = $stmt->fetchAll();
        foreach ($products as $product) {
            $result[$product['id']] = new self ($product['id'], $product['name'], $product['price'], $product['img_url']);
        }
            return $result;

    }

    public static function getById(int $id): ?Product
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM products WHERE id=:id");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();
        if ($product === false) {
            return null;
        } else {
            $obj = new self($product["id"], $product["name"], $product["price"], $product["img_url"]);
            return $obj;
        }

    }
}