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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .container {
            margin-top: 50px;
        }
        .form-container {
            width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <h2 class="mb-4">User Registration</h2>
                    <?php
                    // Display registration error message if exists
                    if (isset($registration_error)) {
                        echo "<div class='alert alert-danger'>$registration_error</div>";
                    }
                    ?>

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                        <div class="mb-3">
                            <label class="form-label" for="username">Username:</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="username">Email:</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Password:</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
