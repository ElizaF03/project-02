<?php

namespace Repository;

use Entity\Favorite;
use ConnectionInterface;

class FavoriteRepository
{
    private ProductRepository $productRepository;
    private ConnectionInterface $connection;

    public function __construct(ProductRepository $productRepository, ConnectionInterface $connection)
    {
        $this->productRepository = $productRepository;
        $this->connection = $connection;
    }

    public
    function getOne(int $userId, int $productId): ?Favorite
    {
        $stmt = $this->connection->execute("SELECT * FROM favorite_user_products JOIN products ON favorite_user_products.product_id=products.id WHERE product_id =:product_id AND user_id =:user_id", (['product_id' => $productId, 'user_id' => $userId]));
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        }
        $product = $this->productRepository->getById($result['product_id']);
        return $this->hydrate($result, $product);
    }

    public function getAllByUserId(int $userId): array
    {
        $stmt = $this->connection->execute("SELECT * FROM favorite_user_products JOIN products ON favorite_user_products.product_id=products.id WHERE user_id =:user_id", (['user_id' => $userId]));
        $favoriteProducts = $stmt->fetchAll();
        if (empty($favoriteProducts)) {
            return [];
        }
        foreach ($favoriteProducts as $favoriteProduct) {
            $product = $this->productRepository->getById($favoriteProduct['product_id']);
            $result[$favoriteProduct['id']] = $this->hydrate($favoriteProduct, $product);
        }
        return $result;
    }

    private function hydrate(array $data, ProductRepository $productRepository): Favorite
    {
        return new Favorite($data["id"], $data['user_id'], $productRepository);
    }

    public function create(int $userId, int $productId): void
    {
        $this->connection->execute("INSERT INTO favorite_user_products (user_id, product_id) VALUES(:user_id, :product_id)", (['user_id' => $userId, 'product_id' => $productId]));
    }

    public function remove(int $userId, int $productId): void
    {
        $this->connection->execute("DELETE FROM favorite_user_products WHERE user_id=:user_id AND product_id=:product_id", (['user_id' => $userId, 'product_id' => $productId]));
    }
}