<?php

use Request\RegistrationRequest;

class App
{
    private Container $container;
    private array $routes = [
    ];

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function run(): void
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        if (isset($this->routes[$requestUri])) {
            if (isset($this->routes[$requestUri][$requestMethod])) {
                $handler = $this->routes[$requestUri][$requestMethod];
                $method = $handler['method'];
                $class = $handler['class'];
                $requestClass = $handler['request'];
            } else {
                echo "Метод $requestMethod не поддерживается для адреса $requestUri";
            }
            $this->container->set(\Controller\CartController::class, function () {
                $authService = new \Service\AuthenticationSessionService();
                $cartService = new \Service\CartService();
                $object = new \Controller\CartController($authService, $cartService);
                return $object;
            });
            $this->container->set(\Controller\ProductController::class, function () {
                $authService = new \Service\AuthenticationSessionService();
                $cartService = new \Service\CartService();
                $object = new \Controller\ProductController($authService, $cartService);
                return $object;
            });
            $this->container->set(\Controller\FavoriteController::class, function () {
                $authService = new \Service\AuthenticationSessionService();
                $cartService = new \Service\CartService();
                $object = new \Controller\FavoriteController($authService, $cartService);
                return $object;
            });
            $this->container->set(\Controller\ProductCardController::class, function () {
                $authService = new \Service\AuthenticationSessionService();
                $cartService = new \Service\CartService();
                $object = new \Controller\ProductCardController($authService, $cartService);
                return $object;
            });
            $this->container->set(\Controller\OrderController::class, function () {
                $authService = new \Service\AuthenticationSessionService();
                $cartService = new \Service\CartService();
                $orderService = new \Service\OrderService();
                $object = new \Controller\OrderController($authService, $cartService, $orderService);
                return $object;
            });
            $this->container->set(\Controller\ReviewController::class, function () {
                $authService = new \Service\AuthenticationSessionService();
                $cartService = new \Service\CartService();
                $object = new \Controller\ReviewController($authService, $cartService);
                return $object;
            });
            $this->container->set(\Controller\UserController::class, function () {
                $authService = new \Service\AuthenticationSessionService();
                $object = new \Controller\UserController($authService);
                return $object;
            });
            $object=$this->container->get($class);
            if ($requestClass !== null) {
                $request = new $requestClass($requestUri, $requestMethod, $_POST);
                $object->$method($request);
            } else {
                $object->$method();
            }
        } else {
            require_once '../View/404.html';
        }
    }

    public function get(string $route, string $class, string $method, string $requestClass = null): void
    {
        $this->routes[$route]['GET'] = [
            'class' => $class,
            'method' => $method,
            'request' => $requestClass];
    }

    public function post(string $route, string $class, string $method, string $requestClass = null): void
    {
        $this->routes[$route]['POST'] = [
            'class' => $class,
            'method' => $method,
            'request' => $requestClass];
    }
}