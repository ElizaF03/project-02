<?php

class App
{
    private array $routes = [
        '/login' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getLogin',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'login',
            ]
        ],
        '/registration' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getRegistration',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'registration',
            ]
        ],
        '/catalog' => [
            'GET' => [
                'class' => 'ProductController',
                'method' => 'getCatalog',
            ],
        ],
        '/cart' => [
            'GET' => [
                'class' => 'CartController',
                'method' => 'getCart',
            ]
        ],
        '/add-product' => [
            'POST' => [
                'class' => 'CartController',
                'method' => 'addProduct',
            ]
        ],
        '/remove-product' => [
            'POST' => [
                'class' => 'CartController',
                'method' => 'removeProduct',
            ]
        ],
        '/favorites' => [
            'GET' => [
                'class' => 'FavoriteController',
                'method' => 'getFavoriteProducts',
            ],
            'POST' => [
                'class' => 'FavoriteController',
                'method' => 'addFavoriteProduct',
            ]
        ],
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
}