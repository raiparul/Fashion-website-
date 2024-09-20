<?php
// Database connection
include '../confi/db_connection.php';

session_start();

// Check if the user is logged in and is a customer
if (!isset($_SESSION['id']) || $_SESSION['usertype'] !== 'customer') {
    header("Location: ../auth/login.php");
    exit();
}

// Fetch customer details
$user_id = $_SESSION['id'];
$query = "SELECT * FROM users WHERE id = ? AND usertype = 'customer'";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$customer = $result->fetch_assoc();
$stmt->close();

// Fetch recent orders for the customer
$orders_query = "SELECT * FROM orders WHERE customer_id = ?";
$stmt = $conn->prepare($orders_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders_result = $stmt->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/customer_dashboard.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome, <?= htmlspecialchars($customer['username']) ?></h1>
        
        <h3 class="mt-4">Recent Orders</h3>
        <?php if ($orders_result->num_rows > 0): ?>
            <ul class="list-group">
                <?php while ($order = $orders_result->fetch_assoc()): ?>
                    <li class="list-group-item">
                        Order ID: <?= $order['order_id'] ?> | Date: <?= $order['order_date'] ?> | Total: $<?= $order['total_amount'] ?> | Status: <?= $order['status'] ?>
                        <a href="view_orders.php?order_id=<?= $order['order_id'] ?>" class="btn btn-sm btn-info float-right">View Details</a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No recent orders found.</p>
        <?php endif; ?>

        <h3 class="mt-4">Browse Products</h3>
        <a href="view_products.php" class="btn btn-primary">View All Products</a>

        <a href="../auth/logout.php" class="btn btn-danger mt-3">Logout</a>
    </div>
    <script src="../../js/customer_dashboard.js" defer></script>
</body>
</html>
