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

    public function getId(): int
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
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'grade' => $grade, 'review' => $review]);
    }

    public static function getByProductId(int $productId): array
    {
        $stmt = self::getPdo()->prepare('SELECT * FROM reviews WHERE product_id = :product_id ORDER BY id DESC');
        $stmt->execute(['product_id' => $productId]);
        $reviews = $stmt->fetchAll();
        if (empty($reviews)) {
            return [];
        }
        foreach ($reviews as $review) {
            $result[$review['id']] =  self::hydrate($review);
        }
        return $result;
    }

    public static function getOne(int $userId, int $productId): ?Review
    {
        $stmt = self::getPdo()->prepare('SELECT * FROM reviews WHERE user_id = :user_id AND product_id = :product_id');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $result = $stmt->fetch();
        if($result===false){
            return null;
        }
        return self::hydrate($result);
    }
    private static function hydrate(array $data): Review
    {
        $obj = new self($data["id"], $data['user_id'], $data['product_id'], $data['grade'], $data['review']);
        return $obj;
    }
}