<?php
include '../confi/db_connection.php';

session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['id']) || $_SESSION['usertype'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Fetch all users
$query = "SELECT * FROM users";
$result = $conn->query($query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Manage Users</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($user = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['usertype']) ?></td>
                            <td>
                                <a href="update_users.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">Update</a>
                                <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5">No users found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>
</body>
</html>
