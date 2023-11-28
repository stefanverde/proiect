<?php
class Speaker {
    private $conn;
    private $table_name = 'speakers';

    public $id;
    public $name;
    public $age;
    public $event_id;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . "(name, age, event_id) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->age = htmlspecialchars(strip_tags($this->age));
        $this->event_id = htmlspecialchars(strip_tags($this->event_id));

        $stmt->bind_param('ssi', $this->name, $this->age, $this->event_id);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error: " . $stmt->error;
            return false;
        }
    }
}
?>
