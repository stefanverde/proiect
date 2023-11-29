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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            width: 50%;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <?php
        if (isset($success_message)) {
            echo "<p style='color: green;'>$success_message</p>";
        } elseif (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>

        <h2>Add Speaker to Event</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Speaker Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="age" class="form-label">Age:</label>
                <input type="number" name="age" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="event_id" class="form-label">Event ID:</label>
                <input type="number" name="event_id" class="form-control" required>
            </div>

            <input type="submit" value="Add Speaker" class="btn btn-primary">
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>

