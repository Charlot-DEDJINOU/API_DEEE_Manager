<?php
class Database{
 
    private $host = "localhost";
    private $db_name = "ecotic";
    private $username = "root";
    private $password = "Charlot1xbet@2003";
    public $conn;
 
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>