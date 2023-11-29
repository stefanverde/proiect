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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .form-container {
            width: 50%;
            margin: auto;
            margin-top: 50px;
        }

        .form-control {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Event</h2>
        <?php
        if (isset($success_message)) {
            echo "<p style=\"color: green;\">$success_message</p>";
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="hidden" name="event_id" value="<?php echo $eventId; ?>">

            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" name="title" class="form-control" value="<?php echo $eventDetails['title']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <input type="text" name="description" class="form-control" value="<?php echo $eventDetails['description']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date:</label>
                <input type="text" name="date" class="form-control" value="<?php echo $eventDetails['date']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location:</label>
                <input type="text" name="location" class="form-control" value="<?php echo $eventDetails['location']; ?>" required>
            </div>

            <input type="submit" value="Update" class="btn btn-primary">
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
