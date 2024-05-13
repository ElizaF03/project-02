<?php
namespace Model;
class UserProduct extends Model
{


    public function getAllByUserId($userId): array|false
    {
        $stmt = $this->getPdo()->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();

    }

    public function getOne(int $userId, int $productId): false|array
    {
        $stmt = $this->getPdo()->prepare('SELECT * FROM user_products WHERE product_id =:product_id AND user_id =:user_id');
        $stmt->execute(['product_id' => $productId, 'user_id' => $userId]);
        return $stmt->fetch();
    }

    public function create(int $userId, int $productId, int $quantity = 1): void
    {
        $stmt = $this->getPdo()->prepare('INSERT INTO user_products (user_id, product_id, quantity) VALUES(:user_id, :product_id, :quantity)');
        $stmt->execute(array('user_id' => $userId, 'product_id' => $productId, 'quantity' => $quantity));
    }

    public function remove(int $userId, int $productId): void
    {
        $stmt = $this->getPdo()->prepare("DELETE FROM user_products WHERE user_id=:user_id AND product_id=:product_id");
        $stmt->execute(array('user_id' => $userId, 'product_id' => $productId));
    }
    public function removeAll(int $userId): void
    {
        $stmt = $this->getPdo()->prepare("DELETE FROM user_products WHERE user_id=:user_id");
        $stmt->execute(array('user_id' => $userId));
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