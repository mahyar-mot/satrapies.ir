<?php


class DbConnection
{
    private $dbName = 'realstate';
    private $host = 'localhost';
    private $username = 'admin';
    private $password = 'admin1234';
    private $conn = '';
    public function __construct()
    {
        try{
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbName", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("SET CHARACTER SET utf8");
        }catch (PDOException $e){
            die ("Connection Failed: ". $e->getMessage());
        }
    }
    public function closeConnection()
    {
        $this->conn = null;
    }
    private function getRecords($query)
    {
        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }catch (PDOException $e){
            return "Error : ". $e->getMessage();
        }
    }
    public function showRecord($query)
    {
        $stmt = $this->getRecords($query);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
