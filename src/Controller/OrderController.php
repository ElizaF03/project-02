<?php

namespace Controller;

use DateTime;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;

class OrderController
{
    public function getOrder(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $userProducts = UserProduct::getAllByUserId($_SESSION['user_id']);
            $totalPrice = $this->calcTotalPrice($userProducts);
            require_once '../View/order.php';
        }
    }

    public function calcTotalPrice($products): float|int
    {
        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += $product->getQuantity() * $product->getProduct()->getPrice();
        }
        return $totalPrice;
    }

    private function validate(string $firstName, string $lastName, string $address, string $phone, int|float $totalPrice): array
    {
        $errors = [];
        if (strlen($firstName) < 2) {
            $errors['first-name'] = 'Name is too short';
        }

        if (strlen($lastName) < 2) {
            $errors['last-name'] = 'Last name is too short';
        }

        if (strlen($address) < 2) {
            $errors['address'] = 'Address is too short';
        }
        if (preg_match('/((8|\+7)-?)?\(?\d{3,5}\)?-?\d{1}-?\d{1}-?\d{1}-?\d{1}-?\d{1}((-?\d{1})?-?\d{1})?/', $phone)) {
            $errors['phone'] = 'Phone number is invalid';
        }
        if ((integer)$totalPrice === 0) {
            $errors['total-price'] = 'Empty order';
        }
        return $errors;
    }

    public function makeOrder(): void
    {
        session_start();
        if (isset($_POST['first-name'])) {
            $firstName = $_POST['first-name'];
        }
        if (isset($_POST['last-name'])) {
            $lastName = $_POST['last-name'];
        }
        if (isset($_POST['address'])) {
            $address = $_POST['address'];
        }
        if (isset($_POST['phone'])) {
            $phone = $_POST['phone'];
        }

        if (isset($_POST['total-price'])) {
            $totalPrice = $_POST['total-price'];
        }
        $errors = $this->validate($firstName, $lastName, $address, $phone, $totalPrice);
        $userId = $_SESSION['user_id'];
        if (empty($errors)) {
            $date = new DateTime();
            $date = $date->format('Y-m-d H:i:s');
            Order::addInfo($userId, $firstName, $lastName, $address, $phone, $totalPrice, $date);
            $userProducts = UserProduct::getAllByUserId($userId);
            $order = Order::getOrder($userId);
            $orderId = $order->getId();
            foreach ($userProducts as $userProduct) {
                OrderProduct::create($orderId, $userProduct->getProduct()->getId(), $userProduct->getQuantity());
            }
            UserProduct::removeAll($userId);
            header('Location: /catalog');
        } else {
            $userProducts = UserProduct::getAllByUserId($userId);
            require_once '../View/order.php';
        }
    }

}