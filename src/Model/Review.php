<?php

namespace Model;

class Review extends Model
{
    public function create($userId, $productId, $grade, $review): void
    {
        $stmt = $this->getPdo()->prepare('INSERT INTO reviews(user_id, product_id, grade, review) VALUES(:user_id, :product_id, :grade, :review)');
        $stmt->execute(array('user_id' => $userId, 'product_id' => $productId, 'grade'=>$grade, 'review' => $review));
    }

    public function getByProductId($productId): false|array
    {
        $stmt = $this->getPdo()->prepare('SELECT * FROM reviews WHERE product_id = :product_id ORDER BY id DESC');
        $stmt->execute(array( 'product_id' => $productId));
        return $stmt->fetchAll();
    }
    public function getOne($userId,$productId): false|array
    {
        $stmt = $this->getPdo()->prepare('SELECT * FROM reviews WHERE user_id = :user_id AND product_id = :product_id');
        $stmt->execute(array( 'user_id' => $userId, 'product_id' => $productId));
        return $stmt->fetch();
    }
}