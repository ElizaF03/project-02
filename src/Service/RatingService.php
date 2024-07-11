<?php

namespace Service;

class RatingService
{
    public function calcRating(array $reviews): float|false
    {
        if (!empty($reviews)) {
            $grades = [];
            foreach ($reviews as $review) {
                $grades[] = $review->getGrade();
            }
            $numb = round(array_sum($grades) / count($grades), 1);
            return $numb;
        } else {
            return  false;
        }
    }
}