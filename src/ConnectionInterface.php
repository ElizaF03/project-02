<?php


interface ConnectionInterface
{
    public static function getInstance();

    public function execute(string $query, ?array $params);

    public function query(string $stmt);

    public function beginTransaction();

    public function rollback();

    public function commit();


}