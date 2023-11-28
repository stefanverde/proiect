<?php
class Event {
    private $conn;
    private $table_name = 'events';

    public $id;
    public $title;
    public $description;
    public $location;
    public $date;


    public function __construct($db){
        $this->conn = $db;
    }

    public function create() {
      $query = "INSERT INTO " . $this->table_name . "(title, description, date, location) VALUES (?, ?, ?, ?)";
      $stmt = $this->conn->prepare($query);

      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->description = htmlspecialchars(strip_tags($this->description));
      $this->location = htmlspecialchars(strip_tags($this->location));
      $this->date = htmlspecialchars(strip_tags($this->date));

      $stmt->bind_param('ssss', $this->title, $this->description, $this->date, $this->location);

      if ($stmt->execute()) {
        return true;
      } else {
          echo "Error: " . $stmt->error;
          return false;
      }
    }

    public function getAllEvents() {
      $query = "SELECT * FROM " . $this->table_name;
      $result = $this->conn->query($query);

      $events = [];
      while ($row = $result->fetch_assoc()) {
          $events[] = $row;
      }
      return $events;
    }

    public function getAllEventsWithSpeakers() {
      $query = "SELECT e.id, e.title, e.description, e.date, e.location, s.id AS speaker_id, s.name AS speaker_name, s.age AS speaker_age
              FROM events e
              LEFT JOIN speakers s ON e.id = s.event_id";
  
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      $result = $stmt->get_result();
  
      $events = array();
  
      while ($row = $result->fetch_assoc()) {
        $eventId = $row['id'];
  
          if (!isset($events[$eventId])) {
              $events[$eventId] = array(
                  'id' => $row['id'],
                  'title' => $row['title'],
                  'description' => $row['description'],
                  'date' => $row['date'],
                  'location' => $row['location'],
                  'speakers' => array()
              );
          }
  
          if (!empty($row['speaker_id'])) {
              $events[$eventId]['speakers'][] = array(
                  'id' => $row['speaker_id'],
                  'name' => $row['speaker_name'],
                  'age' => $row['speaker_age']
              );
          }
      }
  
      return $events;
  }
  

    public function deleteEventById($id) {
      $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
      $stmt = $this->conn->prepare($query);

      $stmt->bind_param('i', $id);

      if ($stmt->execute()) {
          return true;
      } else {
          echo "Error: " . $stmt->error;
          return false;
      }
    }

    public function edit() {
      $query = "UPDATE " . $this->table_name . " SET title=?, description=?, date=?, location=? WHERE id=?";
      $stmt = $this->conn->prepare($query);

      $this->id = htmlspecialchars(strip_tags($this->id));
      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->description = htmlspecialchars(strip_tags($this->description));
      $this->location = htmlspecialchars(strip_tags($this->location));
      $this->date = htmlspecialchars(strip_tags($this->date));

      $stmt->bind_param('ssssi', $this->title, $this->description, $this->date, $this->location, $this->id);

      if ($stmt->execute()) {
          return true;
      } else {
          echo "Error: " . $stmt->error;
          return false;
      }
    }

    public function getEventById($id) {
      $query = "SELECT * FROM " . $this->table_name . " WHERE id=?";
      $stmt = $this->conn->prepare($query);
      $stmt->bind_param('i', $id);
      $stmt->execute();
      $result = $stmt->get_result();

      return $result->fetch_assoc();
    }
}
?>
