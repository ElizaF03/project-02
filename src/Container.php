<?php

class Container
{
     private array $services = [];
     public function __construct($services = []){
         $this->services = $services;
     }

    /**
     * @return array
     */
    public function getServices(): array
    {
        return $this->services;
    }
    public function get(string $class)
    {
        $func = $this->services[$class];
        return $func($this);
    }

    public function set(string $className, callable $func): void
    {
        $this->services[$className] = $func;
    }
}