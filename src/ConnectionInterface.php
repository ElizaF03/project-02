<?php

interface ConnectionInterface
{
    public function execute(string $stmt, ?array $query);
    public function query(string $stmt);

}