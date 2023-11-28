<?php
class User {
    private $conn;
    private $table_name = 'users';

    public $id;
    public $username;
    public $email;
    public $password;


    public function __construct($db){
        $this->conn = $db;
    }

    public function register(){
        $query = "INSERT INTO " . $this->table_name . " (username, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bind_param('sss', $this->username, $this->email, $this->password);
    
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
    
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error: " . $stmt->error;
            return false;
        }
    }

    public function login() {
        $this->username = htmlspecialchars(strip_tags($this->username));
        
        $query = "SELECT id, username, email, password FROM " . $this->table_name . " WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($this->password, $row['password'])) {
                $this->id = $row['id'];
                $this->username = $row['username'];
                return true;
            }
        }
        return false;
    }
}
?>
