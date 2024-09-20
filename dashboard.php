<?php
include '../confi/db_connection.php';

session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['id']) || $_SESSION['usertype'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Fetch admin details (optional)
$admin_id = $_SESSION['id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/admin_dashboard.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome, <?= htmlspecialchars($admin['username']) ?></h1>

        <h3 class="mt-4">Admin Dashboard</h3>
        <div class="list-group">
            <a href="manage_users.php" class="list-group-item list-group-item-action">Manage Users</a>
            <a href="manage_site.php" class="list-group-item list-group-item-action">Manage Site</a>
            <!-- Add more admin features as needed -->
        </div>

        <a href="../auth/logout.php" class="btn btn-danger mt-3">Logout</a>
    </div>
    <script src="../../js/admin_dashboard.js" defer></script>
</body>
</html>
