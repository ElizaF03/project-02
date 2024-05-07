<?php
namespace Model;
class Product extends Model
{
    private int $id;
    private string $name;
    private float $price;
    private string $img_url;

    public function getAll():array{
        $stmt= $this->getPdo()->query("SELECT * FROM products");
        return $stmt->fetchAll();
    }
    public function getById($id): false|array
    {
        $stmt= $this->getPdo()->query("SELECT * FROM products WHERE id=$id");
        return $stmt->fetch();
    }
}