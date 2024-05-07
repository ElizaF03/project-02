<?php

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
                $method = $this->routes[$requestUri]["$requestMethod"]['method'];
                $class = $this->routes[$requestUri]["$requestMethod"]['class'];
            } else {
                echo "Метод $requestMethod не поддерживается для адреса $requestUri";
            }
            $object = new $class();
            $object->$method();
        } else {
            require_once './View/404.html';
        }
    }
    public function addRoute(string $route, string $requestMethod, string $class, string $method): void{
      $this->routes[$route][$requestMethod]=
      ['class' => $class, 'method' => $method];
    }
}