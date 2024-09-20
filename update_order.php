<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['usertype'] !== 'vendor') {
    header("Location: ../auth/login.php");
    exit();
}

include '../confi/db_connection.php';

// Get the order ID from the URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch the current status of the order
    $stmt = $conn->prepare("SELECT status FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $stmt->bind_result($current_status);
    $stmt->fetch();
    $stmt->close();
} else {
    header("Location: manage_orders.php");
    exit();
}

// Update order status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
    $stmt->bind_param("si", $status, $order_id);

    if ($stmt->execute()) {
        header("Location: manage_orders.php");
        exit();
    } else {
        $error = "Error updating order status.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order Status</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/vendor.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Update Order Status</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" class="form-control" required>
                    <option value="Pending" <?= $current_status === 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Shipped" <?= $current_status === 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                    <option value="Delivered" <?= $current_status === 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                    <option value="Cancelled" <?= $current_status === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
        <a href="manage_orders.php" class="btn btn-secondary mt-3">Back to Orders</a>
    </div>
</body>
</html>
