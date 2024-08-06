<?php

namespace Service;

use Repository\ImageRepository;

class ImageService
{
    private ImageRepository $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }
    public function uploadImg($file, $name): void
    {
        copy($file['tmp_name'], './../public/images/' . $name);
    }
    public function addImage(int $productId, int $reviewId,): void
    {
        $file = $_FILES['img'];
        if (isset($file)) {
            $name = mt_rand(0, 1000) . $file['name'];
            $this->uploadImg($file, $name);
            $path='http://localhost:8081/images/';
            $image = $path. $name;
            $this->imageRepository->create($productId, $reviewId, $image);
        }
    }
    public function getImage( int $reviewId)
    {
        $image = $this->imageRepository->getOne($reviewId);
        if($image){
            return $image;
        }
      return false;
    }
}