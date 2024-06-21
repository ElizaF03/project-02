<?php

class Container
{
    private array $services = [];

    /**
     * @param array $services
     */
    public function setServices(array $services): void
    {
        $this->services = $services;
    }
    public function getServices(): array{
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