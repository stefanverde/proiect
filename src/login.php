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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
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
    <div class="login-container">
        <h1>LOGIN</h1>
        <?php
        if (isset($login_error)) {
            echo "<p>$registration_error</p>";
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <input type="submit" value="Login" class="btn btn-primary">
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
