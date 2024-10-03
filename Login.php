<?php
require 'db_config.php'; // Include the database configuration

// Initialize error message
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Connect to the database
    $conn = mysqli_connect(RHOST, RUSER, RPASS, DB);
    if ($conn) {
        // Prepare and execute the SQL statement
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verify the password
        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['username'] = $user['username'];

            // Redirect to index.php after successful login
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }

        $stmt->close();
    } else {
        $error = "Connection failed: " . mysqli_connect_error();
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Signup here</a></p>

        <!-- Display error message -->
        <?php if (!empty($error)): ?>
            <div class="error">
                <p><?php echo htmlspecialchars($error); ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
