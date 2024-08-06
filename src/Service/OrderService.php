<?php

namespace Service;

use ConnectionInterface;
use Repository\OrderProductRepository;
use Repository\OrderRepository;
use Repository\UserProductRepository;
use Throwable;

class OrderService
{
    private OrderRepository $orderRepository;
    private OrderProductRepository $orderProductRepository;
    private UserProductRepository $userProductRepository;
    private ConnectionInterface $connection;


    public function __construct(OrderRepository $orderRepository, OrderProductRepository $orderProductRepository, UserProductRepository $userProductRepository, ConnectionInterface $connection)
    {
        $this->orderRepository = $orderRepository;
        $this->orderProductRepository = $orderProductRepository;
        $this->userProductRepository = $userProductRepository;
        $this->connection = $connection;
    }

    public function searchProductInOrders($orders, $productId): bool
    {
        foreach ($orders as $order) {
            $orderId = $order->getId();
            $productFromOrder = $this->orderProductRepository->getOne($orderId, $productId);
            if ($productFromOrder !== null) {
                return true;
            }
        }
        return false;
    }

    public function createOrder(int $userId, array $data): void

    {
        $pdo = $this->connection;
        $this->connection->beginTransaction();
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
            $this->connection->rollBack();
        }
        $this->connection->commit();
    }
}