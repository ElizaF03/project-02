<?php

namespace Entity;

class Image
{
    private int $id;
    private Product $product;
    private Review $review;
    private string $path;


    public  function __construct(int $id, Product $product, Review $review, string $path)
    {
        $this->id = $id;
        $this->product = $product;
        $this->review = $review;
        $this->path = $path;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getReview(): Review
    {
        return $this->review;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}