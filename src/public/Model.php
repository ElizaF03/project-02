<?php


class Model
{
    private PDO $pdo;



    public function getPdo(): PDO
    {
        return  $this->pdo = new PDO('pgsql:host=db;port=5432;dbname=dbname', 'dbuser', 'dbpwd');;

    }
}