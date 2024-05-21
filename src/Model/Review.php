<?php

namespace Model;

class Review extends Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $grade;
    private string $review;

    public function __construct(int $id, int $userId, int $productId, int $grade, string $review)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->productId = $productId;
        $this->grade = $grade;
        $this->review = $review;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getGrade()
    {
        return $this->grade;
    }

    public function getReview()
    {
        return $this->review;
    }

    public static function create(int $userId, int $productId, int $grade, string $review): void
    {
        $stmt = self::getPdo()->prepare('INSERT INTO reviews(user_id, product_id, grade, review) VALUES(:user_id, :product_id, :grade, :review)');
        $stmt->execute(array('user_id' => $userId, 'product_id' => $productId, 'grade' => $grade, 'review' => $review));
    }

    public static function getByProductId(int $productId): array
    {
        $stmt = self::getPdo()->prepare('SELECT * FROM reviews WHERE product_id = :product_id ORDER BY id DESC');
        $stmt->execute(array('product_id' => $productId));
        $reviews = $stmt->fetchAll();
        foreach ($reviews as $review) {
            $result[$review['id']] = new self($review['id'], $review['user_id'], $review['product_id'], $review['grade'], $review['review']);
        }
        return $result;
    }

    public static function getOne(int $userId, int $productId): ?Review
    {
        $stmt = self::getPdo()->prepare('SELECT * FROM reviews WHERE user_id = :user_id AND product_id = :product_id');
        $stmt->execute(array('user_id' => $userId, 'product_id' => $productId));
        $result = $stmt->fetch();
        $obj = new self($result['id'], $result['user_id'], $result['product_id'], $result['grade'], $result['review']);
        return $obj;
    }
}