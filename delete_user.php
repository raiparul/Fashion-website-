<?php
include '../confi/db_connection.php';

session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['id']) || $_SESSION['usertype'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['id'];

    // Before deleting the user, handle related records in the `orders` table.
    $delete_orders_query = "DELETE FROM orders WHERE customer_id = ?";
    $stmt = $conn->prepare($delete_orders_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    // Now, delete the user from the `users` table.
    $delete_user_query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_user_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_users.php");
    exit();
}

// Fetch user data for confirmation
$user_id = $_GET['id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Delete User</h1>
        <p>Are you sure you want to delete the following user?</p>
        <ul>
            <li>Username: <?= htmlspecialchars($user['username']) ?></li>
            <li>Email: <?= htmlspecialchars($user['email']) ?></li>
            <li>User Type: <?= htmlspecialchars($user['usertype']) ?></li>
        </ul>
        <form action="delete_user.php" method="post">
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="manage_users.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
