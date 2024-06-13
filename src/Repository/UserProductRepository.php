<?php

namespace Repository;

use Repository\Repository;

class UserProductRepository extends Repository
{
    public function getAllByUserId(int $userId): array
    {
        $stmt = $this->getPdo()->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $userProducts= $stmt->fetchAll();
        if (empty($userProducts)) {
            return [];
        }
        foreach ($userProducts as $userProduct) {
            $user=UserRepository::class->getById($userProduct["user_id"]);
            $product=ProductRepository::class->getById($userProduct["product_id"]);
            $result[$userProduct['id']] = $this->hydrate($userProduct, $user, $product);
        }
        return $result;
    }

    public function getOne(int $userId, int $productId): ?UserProductRepository
    {
        $stmt = $this->getPdo()->prepare('SELECT * FROM user_products WHERE product_id =:product_id AND user_id =:user_id');
        $stmt->execute(['product_id' => $productId, 'user_id' => $userId]);
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        }
        $user=User::getById($result["user_id"]);
        if($user===null){
            return null;
        }
        $product=Product::getById($result["product_id"]);
        if($product===null){
            return null;
        }
        return $this->hydrate($result, $user, $product);
    }
    private function hydrate(array $data, UserRepository $user, ProductRepository $product): UserProductRepository
    {
        $obj = new self($data["id"], $user, $product, $data["quantity"]);
        return $obj;
    }
    public function create(int $userId, int $productId, int $quantity = 1): void
    {
        $stmt = $this->getPdo()->prepare('INSERT INTO user_products (user_id, product_id, quantity) VALUES(:user_id, :product_id, :quantity)');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public function remove(int $userId, int $productId): void
    {
        $stmt = $this->getPdo()->prepare("DELETE FROM user_products WHERE user_id=:user_id AND product_id=:product_id");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
    }

    public function removeAll(int $userId): void
    {
        $stmt = $this->getPdo()->prepare("DELETE FROM user_products WHERE user_id=:user_id");
        $stmt->execute(['user_id' => $userId]);
    }

    public function plusQuantity(int $userId, int $productId)
    {
        $stmt = $this->getPDO()->prepare('UPDATE user_products SET quantity = quantity+1  WHERE product_id =:product_id AND user_id =:user_id');
        $stmt->execute(['product_id' => $productId, 'user_id' => $userId]);
        return $stmt->fetch();
    }

    public function minusQuantity(int $userId, int $productId)
    {
        $stmt = $this->getPDO()->prepare('UPDATE user_products SET quantity = quantity-1  WHERE product_id =:product_id AND user_id =:user_id');
        $stmt->execute(['product_id' => $productId, 'user_id' => $userId]);
        return $stmt->fetch();
    }
}