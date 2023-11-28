<?php
class User {
    private $conn;
    private $table_name = 'users';

    public $id;
    public $username;
    public $password;

    public function __construct($db){
        $this->conn = $db;
    }

    public function register(){
        $query = "INSERT INTO " . $this->table_name . " (username, password) VALUES (:username, :password)";
        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function login(){
        $query = "SELECT id, username, password FROM " . $this->table_name . " WHERE username = :username";

        $stmt = $this->conn->prepare($query);
        $this->username = htmlspecialchars(strip_tags($this->username));
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if(password_verify($this->password, $row['password'])){
            $this->id = $row['id'];
            $this->username = $row['username'];
            return true;
        }
        return false;
    }
}
?>
