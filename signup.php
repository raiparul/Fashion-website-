<?php
include '../confi/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>Form Submitted</pre>"; // Debug output to check if form is submitted

    // Retrieve and sanitize form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $usertype = $_POST['usertype'];

    // Validate user type
    $valid_user_types = ['customer', 'vendor', 'admin'];
    if (!in_array($usertype, $valid_user_types)) {
        echo "Invalid user type.";
        exit();
    }

    // Prepare and execute SQL statement
    $query = "INSERT INTO users (username, email, password, usertype) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssss", $username, $email, $password, $usertype);
    if ($stmt->execute()) {
        echo "<pre>Insert successful</pre>"; // Debug output to check if insert is successful
        header("Location: ../auth/login.php");  // Redirect to login page after successful signup
        exit();
    } else {
        echo "<pre>Error: " . $stmt->error . "</pre>"; // Debug output to check for SQL errors
    }
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/signup.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Sign Up</h1>
        <form action="signup.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="usertype">User Type</label>
                <select id="usertype" name="usertype" class="form-control" required>
                    <option value="customer">Customer</option>
                    <option value="vendor">Vendor</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Sign Up</button>
        </form>
    </div>
</body>
</html>
