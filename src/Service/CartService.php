<?php

namespace Service;

use Model\UserProduct;
use Repository\UserProductRepository;

class CartService
{
    private  UserProductRepository $userProductRepository;
    public function __construct(UserProductRepository $userProductRepository){
        $this->userProductRepository = $userProductRepository;
    }
    public function getTotalQuantity(int $userId): int
    {
        $userProducts = $this->userProductRepository->getAllByUserId($userId);
        $sum = 0;
        foreach ($userProducts as $userProduct) {
            $sum += $userProduct->getQuantity();
        }
        return $sum;
    }

    public function calcTotalPrice($userProducts): float|int
    {
        $totalPrice = 0;
        foreach ($userProducts as $userProduct) {
            $totalPrice += $userProduct->getQuantity() * $userProduct->getProduct()->getPrice();
        }
        return $totalPrice;
    }
}