<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['usertype'] !== 'customer') {
    header("Location: ../auth/login.php");
    exit();
}

include '../confi/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = $_SESSION['id'];
    $total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : 0;
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';

    if (empty($address)) {
        $error = "Address is required.";
    } else {
        // Prepare SQL for inserting order
        $stmt = $conn->prepare("INSERT INTO orders (customer_id, total_amount, address, payment_method, order_date) VALUES (?, ?, ?, ?, NOW())");
        if ($stmt) {
            $stmt->bind_param("idss", $customer_id, $total_amount, $address, $payment_method);
            if ($stmt->execute()) {
                $order_id = $stmt->insert_id;

                // Insert order items from cart
                $cart_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) SELECT ?, product_id, quantity FROM cart WHERE customer_id = ?");
                if ($cart_stmt) {
                    $cart_stmt->bind_param("ii", $order_id, $customer_id);
                    $cart_stmt->execute();
                    $cart_stmt->close();

                    // Clear cart
                    $clear_cart_stmt = $conn->prepare("DELETE FROM cart WHERE customer_id = ?");
                    $clear_cart_stmt->bind_param("i", $customer_id);
                    $clear_cart_stmt->execute();
                    $clear_cart_stmt->close();

                    $success = "Order placed successfully!";
                } else {
                    $error = "Error adding items to order.";
                }
            } else {
                $error = "Error placing order.";
            }
            $stmt->close();
        } else {
            $error = "Error preparing statement.";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/customer.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Checkout</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        <form action="checkout.php" method="post">
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="payment_method">Payment Method:</label>
                <select id="payment_method" name="payment_method" class="form-control" required>
                    <option value="Credit Card">Credit Card</option>
                    <option value="PayPal">PayPal</option>
                    <option value="Bank Transfer">Bank Transfer</option>
                </select>
            </div>
            <input type="hidden" name="total_amount" value="<?php echo htmlspecialchars($total_amount); ?>">
            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>
        <a href="view_orders.php" class="btn btn-secondary mt-3">Back to Orders</a>
    </div>
</body>
</html>
