<?php

namespace Entity;

use Repository\ImageRepository;
use Repository\ProductRepository;
use Repository\ReviewRepository;

class Image extends ImageRepository
{
    private int $id;
    private int $productId;
    private int $reviewId;
    private string $path;


    public  function __construct(int $id, int $productId, int$reviewId, string $path)
    {
        $this->id = $id;
        $this->productId = $productId;
        $this->reviewId = $reviewId;
        $this->path = $path;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProduct(): int
    {
        return $this->productId;
    }

    public function getReview(): int
    {
        return $this->reviewId;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}