<?php


class Database
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbName = 'shopping_cart';

    public function connect()
    {
        return new mysqli($this->host,$this->username, $this->password, $this->dbName);
    }
}