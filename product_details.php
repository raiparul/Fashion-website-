<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../confi/db_connection.php';

// Check if a product ID is provided in the URL
if (!isset($_GET['product_id'])) {
    echo "Invalid product ID!";
    exit();
}

$product_id = $_GET['product_id'];

// Prepare the SQL statement to retrieve product details
$query = "SELECT * FROM products WHERE product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the product exists
if ($result->num_rows == 0) {
    echo "Product not found!";
    exit();
}

$product = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/product_details.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Product Details</h1>
        
        <div class="card">
            <div class="card-header">
                <?= htmlspecialchars($product['product_name']) ?>
            </div>
            <div class="card-body">
                <div class="image-container">
                    <img src="../../uploads/<?= htmlspecialchars($product['image']) ?>" alt="Product Image">
                </div>
                <div class="details-container">
                    <p><strong>Description:</strong> <?= htmlspecialchars($product['description']) ?></p>
                    <p><strong>Price:</strong> $<?= htmlspecialchars(number_format($product['price'], 2)) ?></p>
                    <p><strong>Stock:</strong> <?= htmlspecialchars($product['stock_quantity']) ?></p>
                    <a href="manage_cart.php?action=add&product_id=<?= $product['product_id'] ?>" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-3">
            <a href="view_products.php" class="btn btn-secondary">Back to Products</a>
            <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
    <script src="../../js/product_details.js" defer></script>
</body>
</html>
