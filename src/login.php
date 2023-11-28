<?php
require_once('./classes/user.php');
require_once('./includes/db_config.php');

$database = new Database();
$conn = $database->getConnection();

$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user->username = $username;
    $user->password = $password;

    if ($user->login($username, $password)) {
        // $_SESSION['username'] = $username;
        header("Location: admin_panel.php");
        exit();
    } else {
        $login_error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>
    <h1>LOGIN</h1>
    <?php
      if (isset($login_error)) {
          echo "<p>$registration_error</p>";
      }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>