<?php
class Database {
    private $host = 'database';
    private $username = 'web-user';
    private $database = 'web-3';
    private $password = 'password';
    public $conn;

    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = mysqli_connect($this->host, $this->username, $this->password,  $this->database);
            if($this->conn->connect_error) {
                die('Connection failed ' . $this->conn->connect_error);
            }
        } catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>
