<?php


class DbConnection
{
    private $dbName = '';
    private $host = '';
    private $username = '';
    private $password = '';

    public function connectToDb ()
    {
        $conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);
    }
}
