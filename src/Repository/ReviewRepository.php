<?php

namespace Repository;

use ConnectionInterface;
use Entity\Review;

class ReviewRepository
{
    private UserRepository $userRepository;
    private ProductRepository $productRepository;
    private ConnectionInterface $connection;

    public function __construct(UserRepository $userRepository, ProductRepository $productRepository, ConnectionInterface $connection,)
    {
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->connection = $connection;
    }

    public function create(int $userId, int $productId, int $grade, string $review): void
    {
        $this->connection->execute("INSERT INTO reviews(user_id, product_id, grade, review) VALUES(:user_id, :product_id, :grade, :review)", (['user_id' => $userId, 'product_id' => $productId, 'grade' => $grade, 'review' => $review]));
    }

    public function getByProductId(int $productId): array
    {
        $stmt = $this->connection->execute("SELECT * FROM reviews WHERE product_id = :product_id ORDER BY id DESC", (['product_id' => $productId]));
        $reviews = $stmt->fetchAll();
        if (empty($reviews)) {
            return [];
        }
        foreach ($reviews as $review) {
            $result[$review['id']] = $this->hydrate($review);
        }
        return $result;
    }

    public function getOne(int $userId, int $productId): ?Review
    {
        $stmt = $this->connection->execute('SELECT * FROM reviews JOIN images ON reviews.id=images.review_id WHERE reviews.user_id = :user_id AND reviews.product_id = :product_id', (['user_id' => $userId, 'product_id' => $productId]));
        $result = $stmt->fetch();
        if (empty($result)) {
            return null;
        }
        return $this->hydrate($result,);
    }

    private function hydrate(array $data): Review
    {
        $user = $this->userRepository->getById($data["user_id"]);
        $product = $this->productRepository->getById($data['product_id']);
        return new Review($data["id"], $user, $product, $data['grade'], $data['review']);
    }
}