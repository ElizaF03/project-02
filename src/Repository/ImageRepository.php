<?php

namespace Repository;

use ConnectionInterface;
use Entity\Image;

class ImageRepository
{

    private ProductRepository $productRepository;
    private ReviewRepository $reviewRepository;
    private ConnectionInterface $connection;

    public function __construct(ProductRepository $productRepository, ReviewRepository $reviewRepository, ConnectionInterface $connection)
    {
        $this->productRepository = $productRepository;
        $this->reviewRepository = $reviewRepository;
        $this->connection = $connection;
    }

    public function create(int $productId, int $reviewId, string $img_url): void
    {
        $this->connection->execute('INSERT INTO images (product_id, review_id, img_url) VALUES(:product_id, :review_id, :img_url)', (['product_id' => $productId, 'review_id' => $reviewId, 'img_url' => $img_url]));
    }

    public function getOne(int $reviewId): ?Image
    {
        $stmt = $this->connection->execute('SELECT * FROM images JOIN reviews ON images.review_id=reviews.id WHERE review_id = :review_id', (['review_id' => $reviewId]));
        $result = $stmt->fetch();
        if (empty($result)) {
            return null;
        }
        return $this->hydrate($result);
    }

    private function hydrate(array $data): Image
    {
        $product = $this->productRepository->getById($data['product_id']);
        $review = $this->reviewRepository->getOne($data['user_id'], $data['product_id']);
        return new Image($data["id"], $product, $review, $data['img_url']);
    }
}