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
            ],
            'POST' => [
                'class' => 'CartController',
                'method' => 'addProduct',
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
            if ($requestMethod === 'GET') {
                $class = $this->routes[$requestUri]['GET']['class'];
                $method = $this->routes[$requestUri]['GET']['method'];
            } elseif ($requestMethod === 'POST') {
                $class = $this->routes[$requestUri]['POST']['class'];
                $method = $this->routes[$requestUri]['POST']['method'];
            }
            $object = new $class();
            $object->$method();
        } else {
            require_once './View/404.html';
        }
    }
}