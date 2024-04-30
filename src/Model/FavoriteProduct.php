<?php

class FavoriteProduct extends Model
{
    public function getOne(int $userId, int $productId): false|array
    {
        $stmt = $this->getPdo()->prepare('SELECT * FROM favorite_user_products WHERE product_id =:product_id AND user_id =:user_id');
        $stmt->execute(['product_id' => $productId, 'user_id' => $userId]);
        return $stmt->fetch();
    }
    public function getAllByUserId(int $userId): array|false
    {
       $stmt=$this->getPdo()->prepare('SELECT * FROM favorite_user_products WHERE user_id =:user_id');
       $stmt->execute(['user_id' => $userId]);
       return $stmt->fetchAll();
    }
    public function create(int $userId, int $productId): void
    {
        $stmt = $this->getPdo()->prepare('INSERT INTO favorite_user_products (user_id, product_id) VALUES(:user_id, :product_id)');
        $stmt->execute(array('user_id' => $userId, 'product_id' => $productId));
    }
    public function remove(int $userId, int $productId): void
    {
        $stmt = $this->getPdo()->prepare("DELETE FROM favorite_user_products WHERE user_id=:user_id AND product_id=:product_id");
        $stmt->execute(array('user_id' => $userId, 'product_id' => $productId));
    }
}