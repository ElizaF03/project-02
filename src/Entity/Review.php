<?php

namespace Entity;

use Repository\ImageRepository;

class Review
{
    private int $id;
    private User $user;
    private Product $product;
    private int $grade;
    private string $review;



    public function __construct(int $id, User $user, Product $product, int $grade, string $review)
    {
        $this->id = $id;
        $this->user = $user;
        $this->product = $product;
        $this->grade = $grade;
        $this->review = $review;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getProduct()
    {
        return $this->product;
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