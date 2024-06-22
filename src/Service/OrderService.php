<?php

namespace Service;

use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;
use PDO;
use Repository\OrderProductRepository;
use Repository\OrderRepository;
use Repository\Repository;
use Repository\UserProductRepository;
use Repository\UserRepository;

class OrderService
{
    private OrderRepository $orderRepository;
    private OrderProductRepository $orderProductRepository;
    private UserProductRepository $userProductRepository;
    private Repository $repository;

    public function __construct(OrderRepository $orderRepository, OrderProductRepository $orderProductRepository, UserProductRepository $userProductRepository, Repository $repository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderProductRepository = $orderProductRepository;
        $this->userProductRepository = $userProductRepository;
        $this->repository = $repository;
    }

    public function createOrder(int $userId, array $data)
    {

        $this->repository->getPdo()->beginTransaction();
        try {
            $this->orderRepository->addInfo($userId, $data['first-name'], $data['last-name'], $data['address'], $data['phone'], $data['total_price'], $data['date']);
            $userProducts = $this->userProductRepository->getAllByUserId($userId);
            $orderId = $this->orderRepository->getOrder($userId)->getUserId();
            foreach ($userProducts as $userProduct) {
                $this->orderProductRepository->create($orderId, $userProduct->getProduct()->getId(), $userProduct->getQuantity());
            }
            $this->userProductRepository->removeAll($userId);
        } catch (\Throwable $exception) {
            $this->repository->getPdo()->rollBack();
        }
        $this->repository->getPdo()->commit();
    }
}