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

    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ? AND vendor_id = ?");
    $stmt->bind_param("ii", $product_id, $vendor_id);

    if ($stmt->execute()) {
        header("Location: manage_products.php");
        exit();
    } else {
        echo "Error deleting product.";
    }

    $stmt->close();
    $conn->close();
}
?>
