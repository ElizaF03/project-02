<?php

namespace Repository;

use ConnectionInterface;
use Entity\UserProduct;

class UserProductRepository
{
    private UserRepository $userRepository;
    private ProductRepository $productRepository;
    private ConnectionInterface $connection;
    public function __construct(UserRepository $userRepository, ProductRepository $productRepository, ConnectionInterface $connection){
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->connection = $connection;
    }
    public function getAllByUserId(int $userId): array
    {
        $stmt = $this->connection->execute("SELECT * FROM user_products WHERE user_id = :user_id",(['user_id' => $userId]));
        $userProducts = $stmt->fetchAll();
        if (empty($userProducts)) {
            return [];
        }
        foreach ($userProducts as $userProduct) {
            $user = $this->userRepository->getById($userProduct["user_id"]);
            $product = $this->productRepository->getById($userProduct["product_id"]);
            $result[$userProduct['id']] = $this->hydrate($userProduct, $user);
        }
        return $result;
    }

    public function getOne(int $userId, int $productId): ?UserProduct
    {
        $stmt = $this->connection->execute('SELECT * FROM user_products WHERE product_id =:product_id AND user_id =:user_id',(['product_id' => $productId, 'user_id' => $userId]));
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        }
        $user = $this->userRepository->getById($result["user_id"]);
        if ($user === null) {
            return null;
        }
        $product = $this->productRepository->getById($result["product_id"]);
        if ($product === null) {
            return null;
        }
        return $this->hydrate($result);
    }

    private function hydrate(array $data): UserProduct
    {
        $user = $this->userRepository->getById($data["user_id"]);
        $product = $this->productRepository->getById($data["product_id"]);
        return new UserProduct($data["id"], $user, $product, $data["quantity"]);
    }

    public function create(int $userId, int $productId, int $quantity = 1): void
    {
        $this->connection->execute('INSERT INTO user_products (user_id, product_id, quantity) VALUES(:user_id, :product_id, :quantity)', (['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]));
    }

    public function remove(int $userId, int $productId): void
    {
        $this->connection->execute("DELETE FROM user_products WHERE user_id=:user_id AND product_id=:product_id",(['user_id' => $userId, 'product_id' => $productId]));
    }

    public function removeAll(int $userId): void
    {
        $this->connection->execute("DELETE FROM user_products WHERE user_id=:user_id",(['user_id' => $userId]));
    }

    public function plusQuantity(int $userId, int $productId)
    {
        $stmt = $this->connection->execute('UPDATE user_products SET quantity = quantity+1  WHERE product_id =:product_id AND user_id =:user_id',(['product_id' => $productId, 'user_id' => $userId]));
        return $stmt->fetch();
    }

    public function minusQuantity(int $userId, int $productId)
    {
        $stmt = $this->connection->execute('UPDATE user_products SET quantity = quantity-1  WHERE product_id =:product_id AND user_id =:user_id', (['product_id' => $productId, 'user_id' => $userId]));
        return $stmt->fetch();
    }
}