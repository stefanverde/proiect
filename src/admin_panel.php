<?php
require_once('./classes/event.php');
require_once('./includes/db_config.php');

$database = new Database();
$conn = $database->getConnection();

$event = new Event($conn);

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $eventId = $_GET['id'];
    if ($event->deleteEventById($eventId)) {
        $delete_message = "Event deleted!";
    } else {
        echo "Event not deleted.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $date = $_POST['date'];

    $event->title = $title;
    $event->description = $description;
    $event->date = $date;
    $event->location = $location;

    if ($event->create())  {
        $success_message = "Event created!";
    } else {
        echo "Event not created.";
    }
}

// Fetch all events
$events = $event->getAllEventsWithSpeakers();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .delete-icon,
        .edit-icon {
            cursor: pointer;
            text-decoration: underline;
            color: blue;
        }
    </style>
</head>
<body>
    <h2>Admin Panel</h2>
    <br><br><br>

    <h3>Creeaza eveniment</h3>
    <?php
    if (isset($success_message)) {
        echo "<p style=\"color: green;\">$success_message</p>";
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="username">Title:</label>
        <input type="text" name="title" required><br><br>

        <label for="username">Description:</label>
        <input type="text" name="description" required><br><br>

        <label for="password">Date:</label>
        <input type="text" name="date" required /><br><br>

        <label for="password">Location:</label>
        <input type="text" name="location" required><br><br>

        <input type="submit" value="Creeaza">
    </form>

    <br><br>
    <h3>Tabel evenimente</h3>
    <table>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Date</th>
            <th>Location</th>
            <th>Speakers</th>
            <th>Action</th>
        </tr>
        <?php foreach ($events as $event): ?>
        <tr>
            <td><?php echo $event['title']; ?></td>
            <td><?php echo $event['description']; ?></td>
            <td><?php echo $event['date']; ?></td>
            <td><?php echo $event['location']; ?></td>
            <td>
                <?php foreach ($event['speakers'] as $speaker): ?>
                    <p><?php echo $speaker['name']; ?> - <?php echo $speaker['age']; ?></p>
                <?php endforeach; ?>
            </td>
            <td>
                <a href="edit_event.php?id=<?php echo $event['id']; ?>">Edit</a>
                <a href="admin_panel.php?action=delete&id=<?php echo $event['id']; ?>" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
</body>
</html>
