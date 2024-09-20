<?php
session_start();

// Initialize the cart if not already done
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle the add to cart action
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        // Check if the product is already in the cart
        if (isset($_SESSION['cart'][$product_id])) {
            // If the product is already in the cart, increase the quantity by 1
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            // If not, add it to the cart with quantity 1
            $_SESSION['cart'][$product_id] = array('product_id' => $product_id, 'quantity' => 1);
        }
    }
    header("Location: manage_cart.php");
    exit();
}

// Handle the update quantity action
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $product_id => $quantity) {
        if ($quantity > 0) {
            $_SESSION['cart'][$product_id]['quantity'] = $quantity;
        } else {
            unset($_SESSION['cart'][$product_id]);
        }
    }
    header("Location: manage_cart.php");
    exit();
}

// Handle the remove from cart action
if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        unset($_SESSION['cart'][$product_id]);
    }
    header("Location: manage_cart.php");
    exit();
}

// Fetch product details for items in the cart
include '../confi/db_connection.php';

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

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/customer.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Your Shopping Cart</h1>

        <?php if (!empty($cart_products)): ?>
            <form method="post" action="manage_cart.php">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_products as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['product_name']) ?></td>
                                <td>$<?= htmlspecialchars(number_format($product['price'], 2)) ?></td>
                                <td>
                                    <input type="number" name="quantities[<?= $product['product_id'] ?>]" value="<?= $product['quantity'] ?>" min="1" class="form-control">
                                </td>
                                <td>$<?= htmlspecialchars(number_format($product['subtotal'], 2)) ?></td>
                                <td>
                                    <a href="manage_cart.php?action=remove&product_id=<?= $product['product_id'] ?>" class="btn btn-danger">Remove</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Total:</strong></td>
                            <td colspan="2">$<?= htmlspecialchars(number_format($total_amount, 2)) ?></td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" name="update_cart" class="btn btn-primary">Update Cart</button>
            </form>
            <a href="place_order.php" class="btn btn-success mt-3">Proceed to Checkout</a>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>

        <a href="view_products.php" class="btn btn-secondary mt-3">Continue Shopping</a>
    </div>
    <script src="../../js/manage_cart.js" defer></script>
</body>
</html>
