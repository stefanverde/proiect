<?php
require_once('./classes/user.php');
require_once('./includes/db_config.php');

$database = new Database();
$conn = $database->getConnection();

$user = new User($conn);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $user->username = $username;
    $user->email = $email;
    $user->password = password_hash($password, PASSWORD_DEFAULT); 

    // Attempt to register the user
    if ($user->register()) {
        // Registration successful - redirect to login page or another location
        header("Location: login.php");
        exit();
    } else {
        // Registration failed
        $registration_error = "Registration failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Page</title>
</head>
<body>
    <h2>User Registration</h2>
    <?php
    // Display registration error message if exists
    if (isset($registration_error)) {
        echo "<p>$registration_error</p>";
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>

        <label for="username">Email:</label>
        <input type="text" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
