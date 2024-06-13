<?php

namespace Entity;

class Review
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
}