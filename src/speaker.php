<?php
require_once('./classes/speaker.php');
require_once('./includes/db_config.php');

$database = new Database();
$conn = $database->getConnection();

$speaker = new Speaker($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $event_id = $_POST['event_id'];

    $speaker->name = $name;
    $speaker->age = $age;
    $speaker->event_id = $event_id;

    if ($speaker->create()) {
        $success_message = "Speaker added to the event!";
    } else {
        $error_message = "Error adding speaker to the event.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Speaker to Event</title>
</head>
<body>
    <?php
    if (isset($success_message)) {
        echo "<p style='color: green;'>$success_message</p>";
    } elseif (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>

    <h2>Add Speaker to Event</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="name">Speaker Name:</label>
        <input type="text" name="name" required><br><br>

        <label for="Age">Age:</label>
        <input type="number" name="age" required></input><br><br>

        <label for="event_id">Event ID:</label>
        <input type="number" name="event_id" required><br><br>

        <input type="submit" value="Add Speaker">
    </form>
</body>
</html>
