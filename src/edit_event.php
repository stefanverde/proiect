<?php
require_once('./classes/event.php');
require_once('./includes/db_config.php');

$database = new Database();
$conn = $database->getConnection();

$event = new Event($conn);

// Check if the form is submitted for editing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventId = $_POST['event_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $date = $_POST['date'];

    $event->id = $eventId;
    $event->title = $title;
    $event->description = $description;
    $event->date = $date;
    $event->location = $location;

    if ($event->edit()) {
        $success_message = "Event updated!";
    } else {
        echo "Event not updated.";
    }
}

// Fetch the event details to pre-populate the form
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];
    $eventDetails = $event->getEventById($eventId);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
</head>
<body>
    <h2>Edit Event</h2>
    <?php
    if (isset($success_message)) {
        echo "<p style=\"color: green;\">$success_message</p>";
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <input type="hidden" name="event_id" value="<?php echo $eventId; ?>">

        <label for="username">Title:</label>
        <input type="text" name="title" value="<?php echo $eventDetails['title']; ?>" required><br><br>

        <label for="username">Description:</label>
        <input type="text" name="description" value="<?php echo $eventDetails['description']; ?>" required><br><br>

        <label for="password">Date:</label>
        <input type="text" name="date" value="<?php echo $eventDetails['date']; ?>" required><br><br>

        <label for="password">Location:</label>
        <input type="text" name="location" value="<?php echo $eventDetails['location']; ?>" required><br><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
