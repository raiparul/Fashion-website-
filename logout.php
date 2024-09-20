<?php
session_start();

// Destroy the session to log out the user
session_unset();
session_destroy();

// Set a flag to indicate that logout was successful
$logged_out = true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Confirmation</title>
    <link rel="stylesheet" href="../../css/logout.css">
</head>
<body>
    <div class="container">
        <?php if ($logged_out): ?>
            <h1>You have been logged out</h1>
            <p>Click <a href="login.php">here</a> to go to the login page.</p>
        <?php else: ?>
            <h1>Logout Failed</h1>
            <p>Something went wrong. Please try again.</p>
        <?php endif; ?>
    </div>
    <script src="../../js/logout.js"></script>
</body>
</html>
