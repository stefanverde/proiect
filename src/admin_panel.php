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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
    <h2 class="text-center mt-5 mb-4">Admin Panel</h2>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3>Creeaza eveniment</h3>
                <?php
                if (isset($success_message)) {
                    echo "<p style=\"color: green;\">$success_message</p>";
                }
                ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="mb-3">
                        <label for="username" class="form-label">Title:</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Description:</label>
                        <input type="text" name="description" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Date:</label>
                        <input type="text" name="date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Location:</label>
                        <input type="text" name="location" class="form-control" required>
                    </div>

                    <input type="submit" value="Creeaza" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h3>Tabel evenimente</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Speakers</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
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
                        <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="edit-icon">Edit</a>
                        <a href="admin_panel.php?action=delete&id=<?php echo $event['id']; ?>" onclick="return confirm('Are you sure you want to delete this event?')" class="delete-icon">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>

