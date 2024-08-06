<?php

namespace Repository;

use ConnectionInterface;
use Entity\Product;

class ProductRepository
{
    protected ConnectionInterface $connection;
    public function __construct(ConnectionInterface $connection){
        $this->connection = $connection;

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
        $stmt = $this->connection->execute("SELECT * FROM products WHERE id=:id",(['id' => $id]));
        $product = $stmt->fetch();
        if ($product === false) {
            return null;
        } else {
            return $this->hydrate($product);
        }
    }
    private function hydrate(array $data): Product
    {
        return new Product($data["id"], $data["name"], $data["price"], $data["img_url"]);
    }
}