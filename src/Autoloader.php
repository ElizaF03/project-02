<?php

class Autoloader
{
    public static function registarte(string $path): void
    {
        $autoload = function (string $className) use ($path) {
            $className = str_replace('\\', '/', $className);
            $path = "$path/$className.php";
            if (file_exists($path)) {
                require_once $path;
                return true;
            } else {
                return false;
            }
        };
        spl_autoload_register($autoload);
    }
}