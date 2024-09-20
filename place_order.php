<?php
session_start();
include '../confi/db_connection.php';

// Check if the customer is logged in
if (!isset($_SESSION['id']) || $_SESSION['usertype'] !== 'customer') {
    header("Location: ../auth/login.php");
    exit();
}

// Fetch cart items from the session
$cart_products = array();
$total_amount = 0;

if (!empty($_SESSION['cart'])) {
    $product_ids = implode(',', array_keys($_SESSION['cart']));
    $query = "SELECT * FROM products WHERE product_id IN ($product_ids)";
    $result = $conn->query($query);

    while ($product = $result->fetch_assoc()) {
        $product_id = $product['product_id'];
        $quantity = $_SESSION['cart'][$product_id]['quantity'];
        $product['quantity'] = $quantity;
        $product['subtotal'] = $product['price'] * $quantity;
        $total_amount += $product['subtotal'];
        $cart_products[] = $product;
    }
}

// Handle the order placement
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_SESSION['id'];
    $order_date = date('Y-m-d H:i:s');
    $status = 'pending';

    // Insert the order into the orders table
    $query = "INSERT INTO orders (customer_id, order_date, total_amount, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isds", $customer_id, $order_date, $total_amount, $status);
    $stmt->execute();

    // Get the inserted order ID
    $order_id = $stmt->insert_id;

    // Insert each cart item into the order_items table
    foreach ($cart_products as $product) {
        $query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiid", $order_id, $product['product_id'], $product['quantity'], $product['price']);
        $stmt->execute();
    }

    // Clear the cart
    $_SESSION['cart'] = array();

    // Redirect to the order confirmation page
    header("Location: order_confirmation.php?order_id=$order_id");
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/customer.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Review Your Order</h1>

        <?php if (!empty($cart_products)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_products as $product): ?>
                        <tr>
                            <td><?= htmlspecialchars($product['product_name']) ?></td>
                            <td>$<?= htmlspecialchars(number_format($product['price'], 2)) ?></td>
                            <td><?= $product['quantity'] ?></td>
                            <td>$<?= htmlspecialchars(number_format($product['subtotal'], 2)) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total:</strong></td>
                        <td>$<?= htmlspecialchars(number_format($total_amount, 2)) ?></td>
                    </tr>
                </tbody>
            </table>

            <form method="post" action="place_order.php">
                <button type="submit" class="btn btn-success">Confirm Order</button>
            </form>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>

        <a href="manage_cart.php" class="btn btn-secondary mt-3">Go Back to Cart</a>
    </div>
    <script src="../../js/place_order.js" defer></script>
</body>
</html>
