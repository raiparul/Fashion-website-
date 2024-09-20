<?php
include '../confi/db_connection.php';
session_start();


if (!isset($_SESSION['id']) || $_SESSION['usertype'] !== 'customer') {
    
}

// Fetch all products
$query = "SELECT * FROM products";
$result = $conn->query($query);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/view_products.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Products</h1>
        <?php if ($result->num_rows > 0): ?>
            <div class="row">
                <?php while ($product = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="../../uploads/<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['product_name']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['product_name']) ?></h5>
                                <p class="card-text">Price: $<?= htmlspecialchars($product['price']) ?></p>
                                <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                                <a href="product_details.php?product_id=<?= $product['product_id'] ?>" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No products available.</p>
        <?php endif; ?>

        <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>
    <script src="../../js/view_products.js" defer></script>
</body>
</html>
