<?php

namespace Repository;

use Entity\Image;
use ConnectionInterface;

class ImageRepository
{
    private ConnectionInterface $connection;
    public function __construct(ConnectionInterface $connection){
        $this->connection = $connection;
    }
    public function create(int $productId, int $reviewId, string $img_url): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO images (product_id, review_id, img_url) VALUES(:product_id, :review_id, :img_url)');
        $stmt->execute(['product_id' => $productId, 'review_id' => $reviewId, 'img_url' => $img_url]);
    }

    public function getOne(int $reviewId): ?Image
    {
        $stmt = $this->pdo->prepare('SELECT * FROM images WHERE review_id = :review_id');
        $stmt->execute(['review_id' => $reviewId]);
        $result = $stmt->fetch();
        if (empty($result)) {
            return null;
        }
        return $this->hydrate($result);
    }

    private function hydrate(array $data): Image
    {
        return new Image($data["id"], $data['product_id'], $data['review_id'], $data['img_url']);
    }
}