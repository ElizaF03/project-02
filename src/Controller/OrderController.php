<?php
namespace Controller;
use DateTime;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;
class OrderController
{
    public function getOrder()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $products=$this->getUserProducts($_SESSION['user_id']);
            $totalPrice=$this->calcTotalPrice($products);
            require_once '../View/order.php';
        }
    }
    public function getUserProducts(int $userId): ?array
    {
        $userProducts = UserProduct::getAllByUserId($userId);
        $productIds = [];
        $products = [];
        foreach ($userProducts as $userProduct) {
            $productIds[] = $userProduct['product_id'];
        }
        foreach ($productIds as $productId) {
            $products[] = Product::getById($productId);
        }
        if(isset($userProduct['quantity']) ){
            foreach ($products as &$product) {
                foreach ($userProducts as $userProduct) {
                    if ($product->getId()=== $userProduct->getId()) {
                        $product['quantity'] = $userProduct->getQuantity();
                    }
                }
            }
        }
        unset($product);
        return $products;
    }

    public function calcTotalPrice($products): float|int
    {
        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += $product['quantity'] * $product['price'];
        }
        return $totalPrice;
    }
    private function validate($firstName, $lastName, $address, $phone, $totalPrice): array
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
        if (empty($errors)) {
            $order = new Order();
            $date = new DateTime();
            $date = $date->format('Y-m-d H:i:s');
            $order->addInfo($_SESSION['user_id'], $firstName, $lastName, $address, $phone, $totalPrice, $date);
            $userProducts = UserProduct::getAllByUserId($_SESSION['user_id']);
            $order = $order->getOrder($_SESSION['user_id']);
            $orderId = $order['id'];
            $orderProduct = new OrderProduct();
            foreach ($userProducts as $product) {
                $orderProduct->create($orderId, $product['product_id'], $product['quantity']);
            }
            UserProduct::removeAll($_SESSION['user_id']);
            header('Location: /catalog');
        } else {
            $products=$this->getUserProducts($_SESSION['user_id']);
            require_once '../View/order.php';
        }
    }

}