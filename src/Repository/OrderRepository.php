<?php

namespace Repository;

use Entity\Order;
use Entity\UserProduct;

class OrderRepository extends Repository
{
    public function addInfo(int $userId, string $firstName, string $lastName, string $address, string $phone, float $totalPrice, string $date): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO orders (user_id, first_name, last_name, address, phone, total_price, date) VALUES(:user_id, :first_name, :last_name, :address, :phone, :total_price, :date)');
        $stmt->execute(['user_id' => $userId, 'first_name' => $firstName, 'last_name' => $lastName, 'address' => $address, 'phone' => $phone, 'total_price' => $totalPrice, 'date' => $date]);
    }

    public function getOrder($userId): ?Order
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC');
        $stmt->execute(['user_id' => $userId]);
        $result = $stmt->fetch();
        if ($result === false) {
            return null;
        }
        $obj = $this->hydrate($result, $userId);
        return $obj;
    }
    public function getAll($userId): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);
        $userOrders = $stmt->fetchAll();
        if (empty($userOrders)) {
            return [];
        }
        foreach ($userOrders as $userOrder) {
            $result[$userOrder['id']] = $this->hydrate($userOrder, $userId);
        }
        return $result;
    }
    private function hydrate(array $result, $userId): Order
    {
        return new Order($result['id'], $userId, $result['first_name'], $result['last_name'], $result['address'], $result['phone'], $result['total_price'], $result['date']);
    }
}