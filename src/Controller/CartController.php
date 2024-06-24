<?php

namespace Controller;

use Model\UserProduct;
use Repository\UserProductRepository;
use Request\ProductRequest;
use Service\AuthenticationInterface;
use Service\CartService;

class CartController
{
    private AuthenticationInterface $authenticationService;
    private CartService $cartService;
    private UserProductRepository $userProductRepository;

    public function __construct(AuthenticationInterface $authenticationService, CartService $cartService, UserProductRepository $userProductRepository)
    {
        $this->authenticationService = $authenticationService;
        $this->cartService = $cartService;
        $this->userProductRepository = $userProductRepository;
    }

    public function getCart(): void
    {
        $user = $this->authenticationService->getUser();
        if ($user === null) {
            header('Location: login');
        }
        $userProducts = $this->userProductRepository->getAllByUserId($user->getId());
        $totalPrice = $this->cartService->calcTotalPrice($userProducts);
        require_once './../View/cart.php';
    }

    public function addProduct(ProductRequest $request): void
    {
        if (!$this->authenticationService->check()) {
            header('Location: login');
        }
        $productId = $request->getProductId();
        $userId = $this->authenticationService->getUser()->getId();
        $oneUserProduct = $this->userProductRepository->getOne($userId, $productId);
        if (!$oneUserProduct) {
            $this->userProductRepository->create($userId, $productId);
        } else {
            $this->userProductRepository->plusQuantity($userId, $productId);
        }
        header('Location: /catalog');
    }

    public function removeProduct(ProductRequest $request): void
    {
        if (!$this->authenticationService->check()) {
            header('Location: login');
        }
        $productId = $request->getProductId();
        $userId = $this->authenticationService->getUser()->getId();
        $oneUserProduct = $this->userProductRepository->getOne($userId, $productId);
        if ($oneUserProduct) {
            if ($oneUserProduct->getQuantity() === 1) {
                $this->userProductRepository->remove($userId, $productId);
            } else {
                $this->userProductRepository->minusQuantity($userId, $productId);
            }
        }
        header('Location: /catalog');
    }
}