<?php

namespace Controller;

use DateTime;
use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;
use Request\OrderRequest;
use Service\AuthenticationInterface;
use Service\CartService;
use Service\OrderService;

class OrderController
{
    private AuthenticationInterface $authenticationService;
    private CartService $cartService;

    public function __construct(AuthenticationInterface $authenticationService, CartService $cartService)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
    }

    public function getOrder(): void
    {
        if (!$this->authenticationService->check()) {
            header('Location: login');
        }
        $userProducts = UserProduct::getAllByUserId($this->authenticationService->getUser()->getId());
        $totalPrice = $this->cartService->calcTotalPrice($userProducts);
        require_once '../View/order.php';
    }

    public function makeOrder(OrderRequest $request): void
    {
        if (!$this->authenticationService->check()) {
            header('Location: login');
        }
        $errors = $request->validate();
        $userId = $this->authenticationService->getUser()->getId();
        if (empty($errors)) {
            $firstName = $request->getFirstName();
            $lastName = $request->getLastName();
            $address = $request->getAddress();
            $phone = $request->getPhone();
            $totalPrice = $request->getTotalPrice();
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