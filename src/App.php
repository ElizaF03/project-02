<?php

use Request\RegistrationRequest;

class App
{
    private array $routes = [
    ];

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
            $authService = new \Service\AuthenticationCookieService();
            $cartService = new \Service\CartService();
            $orderService = new \Service\OrderService();
            $object = new $class($authService, $cartService, $orderService);
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