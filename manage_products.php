<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['usertype'] !== 'vendor') {
    header("Location: ../auth/login.php");
    exit();
}

include '../confi/db_connection.php';

$vendor_id = $_SESSION['id'];

// Fetch products for the logged-in vendor
$stmt = $conn->prepare("SELECT product_id, product_name, description, price, stock_quantity, category, image FROM products WHERE vendor_id = ?");
$stmt->bind_param("i", $vendor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link href="../../assets/css/vendor.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="../../css/manage_products.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Manage Products</h1>
        <a href="add_product.php" class="btn btn-primary mb-3">Add New Product</a>
        <a href="view_products.php" class="btn btn-secondary">View Products</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php if ($row['image']): ?>
                                <img src="../../uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['product_name']) ?>" width="100">
                            <?php else: ?>
                                <img src="../../assets/images/product_default.jpg" alt="Default Image" width="100">
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['product_name']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td><?= htmlspecialchars($row['price']) ?></td>
                        <td><?= htmlspecialchars($row['stock_quantity']) ?></td>
                        <td><?= htmlspecialchars($row['category']) ?></td>
                        <td>
                            <a href="edit_product.php?id=<?= $row['product_id'] ?>" class="btn btn-warning">Edit</a>
                            <a href="delete_product.php?id=<?= $row['product_id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
