<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['usertype'] !== 'vendor') {
    header("Location: ../auth/login.php");
    exit();
}

include '../confi/db_connection.php';

$vendor_id = $_SESSION['id'];
$orders = [];

// Query to get orders that involve the vendor's products
$sql = "SELECT o.order_id, o.customer_id, o.order_date, o.total_amount, o.status 
        FROM orders o
        WHERE o.order_id IN (
            SELECT order_id 
            FROM order_items oi 
            JOIN products p ON p.product_id = oi.product_id 
            WHERE p.vendor_id = ?
        )";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $vendor_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/vendor.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Manage Orders</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['order_id']) ?></td>
                        <td><?= htmlspecialchars($order['customer_id']) ?></td>
                        <td><?= htmlspecialchars($order['order_date']) ?></td>
                        <td><?= htmlspecialchars($order['total_amount']) ?></td>
                        <td><?= htmlspecialchars($order['status']) ?></td>
                        <td>
                        <td>
    <a href="update_order.php?order_id=<?= htmlspecialchars($order['order_id']) ?>" class="btn btn-primary">Update</a>
</td>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="vendor_dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>
</body>
</html>
