<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['usertype'] !== 'vendor') {
    header("Location: ../auth/login.php");
    exit();
}

include '../confi/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $vendor_id = $_SESSION['id'];

    $stmt = $conn->prepare("SELECT product_name, description, price, stock_quantity, category, image FROM products WHERE product_id = ? AND vendor_id = ?");
    $stmt->bind_param("ii", $product_id, $vendor_id);
    $stmt->execute();
    $stmt->bind_result($product_name, $description, $price, $stock_quantity, $category, $image);
    $stmt->fetch();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];
    $category = $_POST['category'];
    $image = $_POST['image']; // You should handle file uploads here

    $stmt = $conn->prepare("UPDATE products SET product_name = ?, description = ?, price = ?, stock_quantity = ?, category = ?, image = ? WHERE product_id = ? AND vendor_id = ?");
    $stmt->bind_param("ssdissii", $product_name, $description, $price, $stock_quantity, $category, $image, $product_id, $vendor_id);

    if ($stmt->execute()) {
        header("Location: manage_products.php");
        exit();
    } else {
        echo "Error updating product.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
</head>
<body>

<h1>Edit Product</h1>

<form action="edit_product.php" method="post">
    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">
    <label for="product_name">Product Name:</label>
    <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>" required><br>

    <label for="description">Description:</label>
    <textarea id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea><br>

    <label for="price">Price:</label>
    <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($price); ?>" required><br>

    <label for="stock_quantity">Stock Quantity:</label>
    <input type="number" id="stock_quantity" name="stock_quantity" value="<?php echo htmlspecialchars($stock_quantity); ?>" required><br>

    <label for="category">Category:</label>
    <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($category); ?>" required><br>

    <label for="image">Image:</label>
    <input type="text" id="image" name="image" value="<?php echo htmlspecialchars($image); ?>"><br>

    <input type="submit" value="Update Product">
</form>

</body>
</html>
