<?php
require 'db_config.php'; // Include the database configuration

// Initialize error messages
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Connect to the database
    $conn = mysqli_connect(RHOST, RUSER, RPASS, DB);
    if ($conn) {
        // Prepare and execute the SQL statement to insert user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            // Start the session and set session variables
            session_start();
            $_SESSION['username'] = $username;

            // Redirect to index.php after successful signup
            header("Location: index.php");
            exit();
        } else {
            $errors[] = "Failed to sign up. Please try again.";
        }

        $stmt->close();
    } else {
        $errors[] = "Connection failed: " . mysqli_connect_error();
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Signup</h2>
        <form action="signup.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Signup</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>

        <!-- Display error messages -->
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
