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
    $username = $_POST['username'];
    $email = $_POST['email'];
    $usertype = $_POST['usertype'];

    $update_query = "UPDATE users SET username = ?, email = ?, usertype = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssi", $username, $email, $usertype, $user_id);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_users.php");
    exit();
}

// Fetch user data
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
    <title>Update User</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Update User</h1>
        <form action="update_user.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>
            <div class="form-group">
                <label for="usertype">User Type:</label>
                <select id="usertype" name="usertype" class="form-control" required>
                    <option value="customer" <?= $user['usertype'] === 'customer' ? 'selected' : '' ?>>Customer</option>
                    <option value="vendor" <?= $user['usertype'] === 'vendor' ? 'selected' : '' ?>>Vendor</option>
                    <option value="admin" <?= $user['usertype'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <input type="hidden" name="id" value="<?= $user['id'] ?>">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="manage_users.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
