<?php

namespace Repository;

use Entity\Product;

class ProductRepository extends Repository
{
    private function hydrate(array $data): Product
    {
        return new Product($data["id"], $data["name"], $data["price"], $data["img_url"]);
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
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
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id=:id");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();
        if ($product === false) {
            return null;
        } else {
            return $this->hydrate($product);
        }
    }
}