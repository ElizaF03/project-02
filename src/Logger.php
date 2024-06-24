<?php

class Logger
{
    public function log($message): void
    {
        $file = fopen("../Storage/Logs/logs.txt", "a+");
        if (!file_exists("../Storage/Logs/logs.txt")) {
            mkdir("../Storage/Logs/logs.txt");
        }
        $message = PHP_EOL . date('Y-m-d H:i:s') . PHP_EOL . $message;
        fwrite($file, $message);
        fclose($file);
    }
}