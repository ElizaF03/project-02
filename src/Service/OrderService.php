<?php

namespace Service;

use Container;
use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;
use PDO;
use Repository\OrderProductRepository;
use Repository\OrderRepository;
use Repository\Repository;
use Repository\UserProductRepository;
use Repository\UserRepository;
use Throwable;

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

    public function createOrder(int $userId, array $data): void

    {
        global $container;
        $pdo = $container->get(PDO::class);
        $pdo->beginTransaction();
        try {
            $this->orderRepository->addInfo($userId, $data['first-name'], $data['last-name'], $data['address'], $data['phone'], $data['total_price'], $data['date']);
            $userProducts = $this->userProductRepository->getAllByUserId($userId);
            $order = $this->orderRepository->getOrder($userId);
            $orderId = $order->getId();
            foreach ($userProducts as $userProduct) {
                $this->orderProductRepository->create($orderId, $userProduct->getProduct()->getId(), $userProduct->getQuantity());
            }
            $this->userProductRepository->removeAll($userId);
        } catch (Throwable $exception) {
            $pdo->rollBack();
        }
        $pdo->commit();
    }
}