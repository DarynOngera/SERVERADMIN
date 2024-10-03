<?php
// Start the session
session_start();

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to Our Website!</h1>
        
        <?php if ($isLoggedIn): ?>
            <h2>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
            <p>You are successfully logged in.</p>
            <p><a href="Login.php">Logout</a></p>
        <?php else: ?>
            <h2>Guest User</h2>
            <p>Please <a href="signup.php">sign up</a> or <a href="login.php">log in</a> to access your account.</p>
        <?php endif; ?>
    </div>
</body>
</html>
