<?php
require_once 'Model.php';
class Product extends Model
{
    private int $id;
    private string $name;
    private float $price;
    private string $img_url;

    public function getProducts():array{
        $stmt= $this->getPdo()->query("SELECT * FROM products");
        return $stmt->fetchAll();
    }
}