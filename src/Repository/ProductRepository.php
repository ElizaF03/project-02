<?php

namespace Repository;

use Entity\Product;
use ConnectionInterface;

class ProductRepository
{
    protected ConnectionInterface $connection;
    public function __construct(ConnectionInterface $connection){
        $this->connection = $connection;

    }
    private function hydrate(array $data): Product
    {
        return new Product($data["id"], $data["name"], $data["price"], $data["img_url"]);
    }

    public function getAll(): array
    {
        $stmt = $this->connection->query("SELECT * FROM products");
        $products = $stmt->fetchAll();
        if (empty($products)) {
            return [];
        }
        foreach ($products as $product) {
            $result[$product['id']] = $this->hydrate($product);
        }
        return $result;
    }

    public function getById(int $id): ?Product
    {
        $query=['id' => $id];
        $stmt = $this->connection->execute("SELECT * FROM products WHERE id=:id",$query);
        $product = $stmt->fetch();
        if ($product === false) {
            return null;
        } else {
            return $this->hydrate($product);
        }
    }
}