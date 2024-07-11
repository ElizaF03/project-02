<?php

namespace Request;

class ReviewRequest extends Request
{


    public function getProductId(): int
    {
        return $this->data['id-product'];
    }
    public function getGrade(): string
    {
        return $this->data['grade'];
    }
    public function getReview(): string
    {
        return $this->data['review'];
    }

}