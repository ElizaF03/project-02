<?php

class Container
{
    private array $objects=[];
public function __construct( array $objects=[] )
{
    $this->objects = $objects;
}

    public function get(string $class): object
    {

        if ($class === \Controller\CartController::class) {
            $authService = new \Service\AuthenticationSessionService();
            $cartService = new \Service\CartService();
            $object = new $class($authService, $cartService);
        } elseif
        ($class === \Controller\OrderController::class) {
            $authService = new \Service\AuthenticationSessionService();
            $cartService = new \Service\CartService();
            $orderService = new \Service\OrderService();
            $object = new $class($authService, $cartService, $orderService);
        } elseif
        ($class === \Controller\FavoriteController::class) {
            $authService = new \Service\AuthenticationSessionService();
            $cartService = new \Service\CartService();
            $object = new $class($authService, $cartService);
        } elseif
        ($class === \Controller\ProductController::class) {
            $authService = new \Service\AuthenticationSessionService();
            $cartService = new \Service\CartService();
            $object = new $class($authService, $cartService);
        }elseif
        ($class === \Controller\ProductCardController::class) {
            $authService = new \Service\AuthenticationSessionService();
            $cartService = new \Service\CartService();
            $object = new $class($authService, $cartService);
        }
        return $object;
    }
}