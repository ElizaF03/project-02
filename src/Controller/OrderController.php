<?php

class OrderController
{
    public function getOrder()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: login');
        } else {
            $userProductController = new UserProductController();
            $products=$userProductController->getUserProducts($_SESSION['user_id'], UserProduct::class);
            require_once '../View/order.php';
        }
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
            $userProduct = new UserProduct();
            $userProducts = $userProduct->getAllByUserId($_SESSION['user_id']);
            $order = $order->getOrder($_SESSION['user_id']);
            $orderId = $order['id'];
            $orderProduct = new OrderProduct();
            foreach ($userProducts as $product) {
                $orderProduct->create($orderId, $product['product_id'], $product['quantity']);
            }
            $userProduct->removeAll($_SESSION['user_id']);
            header('Location: /cart');
        } else {

            $userProductController = new UserProductController();
            $products=$userProductController->getUserProducts($_SESSION['user_id'], UserProduct::class);
            require_once '../View/order.php';
        }
    }

}