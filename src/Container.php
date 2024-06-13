<?php

class Container
{
    private array $services = [];


    public function get(string $class): object
    {
        $func = $this->services[$class];
        $object = $func();
        return $object;
    }

    public function set(string $className, callable $func)
    {
        $this->services[$className] = $func;
    }
}