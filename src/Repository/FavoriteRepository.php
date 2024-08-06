<?php

namespace Repository;

use ConnectionInterface;
use Entity\Favorite;

class FavoriteRepository
{
    private UserRepository $userRepository;
    private ProductRepository $productRepository;
    private ConnectionInterface $connection;

    public function __construct(UserRepository $userRepository,  ProductRepository $productRepository, ConnectionInterface $connection)
    {
        $this->userRepository=$userRepository;
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
        return $this->hydrate($result);
    }

    public function getAllByUserId(int $userId): array
    {
        $stmt = $this->connection->execute("SELECT * FROM favorite_user_products JOIN products ON favorite_user_products.product_id=products.id WHERE user_id =:user_id", (['user_id' => $userId]));
        $favoriteProducts = $stmt->fetchAll();
        if (empty($favoriteProducts)) {
            return [];
        }
        foreach ($favoriteProducts as $favoriteProduct) {
            $result[$favoriteProduct['id']] = $this->hydrate($favoriteProduct);
        }
        return $result;
    }

    private function hydrate(array $data): Favorite
    {
        $user = $this->userRepository->getById($data["user_id"]);
        $product = $this->productRepository->getById($data['product_id']);
        return new Favorite($data["id"], $user, $product);
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