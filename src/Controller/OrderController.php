<?php

namespace Controller;

use DateTime;
use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;
use Repository\UserProductRepository;
use Request\OrderRequest;
use Service\AuthenticationInterface;
use Service\CartService;
use Service\OrderService;

class OrderController
{
    private AuthenticationInterface $authenticationService;
    private CartService $cartService;
    private OrderService $orderService;
    private UserProductRepository $userProductRepository;

    public function __construct(AuthenticationInterface $authenticationService, CartService $cartService, OrderService $orderService, UserProductRepository $userProductRepository)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
        $this->orderService = $orderService;
        $this->userProductRepository = $userProductRepository;
    }

    public function getOrder(): void
    {
        $user = $this->authenticationService->getUser();
        if ($user === null) {
            header('Location: login');
        }
        $userProducts = $this->userProductRepository->getAllByUserId($user->getId());
        $totalPrice = $this->cartService->calcTotalPrice($userProducts);
        require_once '../View/order.php';
    }

    public function makeOrder(OrderRequest $request): void
    {
        $user = $this->authenticationService->getUser();
        if ($user === null) {
            header('Location: login');
        }
        $errors = $request->validate();
        $userId = $user->getId();
        if (empty($errors)) {
            $firstName = $request->getFirstName();
            $lastName = $request->getLastName();
            $address = $request->getAddress();
            $phone = $request->getPhone();
            $totalPrice = $request->getTotalPrice();
            $date = new DateTime();
            $date = $date->format('Y-m-d H:i:s');
            $data=['first-name'=>$firstName, 'last-name'=>$lastName, 'address'=>$address, 'phone'=>$phone, 'total_price'=>$totalPrice, 'date'=>$date];
            $this->orderService->createOrder($userId, $data);
            header('Location: /catalog');
        } else {
            $userProducts = $this->userProductRepository->getAllByUserId($userId);
            require_once '../View/order.php';
        }
    }
}