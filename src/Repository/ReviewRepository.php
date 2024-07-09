<?php

namespace Repository;

use Entity\Review;

class ReviewRepository extends Repository
{
    private ImageRepository$imageRepository;
    public function __construct(ImageRepository $imageRepository){
        parent::__construct();
        $this->imageRepository = $imageRepository;
    }
    public function create(int $userId, int $productId, int $grade, string $review): void
    {
        $stmt =  $this->pdo->prepare('INSERT INTO reviews(user_id, product_id, grade, review) VALUES(:user_id, :product_id, :grade, :review)');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'grade' => $grade, 'review' => $review]);
    }

    public function getByProductId(int $productId): array
    {
        $stmt =  $this->pdo->prepare('SELECT * FROM reviews WHERE product_id = :product_id ORDER BY id DESC');
        $stmt->execute(['product_id' => $productId]);
        $reviews = $stmt->fetchAll();
        if (empty($reviews)) {
            return [];
        }
        foreach ($reviews as $review) {
            $img=$this->imageRepository->getOne($review['id']);
            $result[$review['id']] =  $this->hydrate($review, $img);
        }
        return $result;
    }

    public function getOne(int $userId, int $productId): ?Review
    {
        $stmt =  $this->pdo->prepare('SELECT * FROM reviews JOIN images ON reviews.id=images.review_id WHERE user_id = :user_id AND product_id = :product_id');
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId]);
        $result = $stmt->fetch();
        if(empty($result)){
            return null;
        }
        $img=$this->imageRepository->getOne($result['id']);
        return $this->hydrate($result, $img);
    }
    private function hydrate(array $data, ImageRepository $imageRepository): Review
    {
        return new Review($data["id"], $data['user_id'], $data['product_id'], $data['grade'], $data['review'], $imageRepository);
    }
}