<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['usertype'] !== 'customer') {
    header("Location: ../auth/login.php");
    exit();
}

include '../confi/db_connection.php';

if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    
    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    
    $stmt->close();
    $conn->close();
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Order Confirmation</h1>
        <p>Thank you for your order!</p>
        <p>Order ID: <?php echo htmlspecialchars($order['order_id']); ?></p>
        <p>Order Status: <?php echo htmlspecialchars($order['status']); ?></p>
        <p>Delivery Address: <?php echo htmlspecialchars($order['address']); ?></p>
        <p>Payment Method: <?php echo htmlspecialchars($order['payment_method']); ?></p>
        <a href="index.php" class="btn btn-primary">Return to Shop</a>
    </div>
</body>
</html>
