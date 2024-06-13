<?php

namespace Repository;

use Entity\Review;

class ReviewRepository extends Repository
{
    public function create(int $userId, int $productId, int $grade, string $review): void
    {
        $stmt =  $this->getPdo()->prepare('INSERT INTO reviews(user_id, product_id, grade, review) VALUES(:user_id, :product_id, :grade, :review)');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'grade' => $grade, 'review' => $review]);
    }

    public function getByProductId(int $productId): array
    {
        $stmt =  $this->getPdo()->prepare('SELECT * FROM reviews WHERE product_id = :product_id ORDER BY id DESC');
        $stmt->execute(['product_id' => $productId]);
        $reviews = $stmt->fetchAll();
        if (empty($reviews)) {
            return [];
        }
        foreach ($reviews as $review) {
            $result[$review['id']] =  $this->hydrate($review);
        }
        return $result;
    }

    public function getOne(int $userId, int $productId): ?Review
    {
        $stmt =  $this->getPdo()->prepare('SELECT * FROM reviews WHERE user_id = :user_id AND product_id = :product_id');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $result = $stmt->fetch();
        if($result===false){
            return null;
        }
        return $this->hydrate($result);
    }
    private function hydrate(array $data): Review
    {
        $obj = new Review($data["id"], $data['user_id'], $data['product_id'], $data['grade'], $data['review']);
        return $obj;
    }
}