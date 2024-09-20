<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['usertype'] !== 'vendor') {
    header("Location: ../auth/login.php");
    exit();
}

include '../confi/db_connection.php';

$vendor_id = $_SESSION['id'];

$stmt = $conn->prepare("SELECT product_id, product_name, description, price, stock_quantity, category, image FROM products WHERE vendor_id = ?");
$stmt->bind_param("i", $vendor_id);
$stmt->execute();

// Correct the bind_result to match the selected columns
$stmt->bind_result($product_id, $product_name, $description, $price, $stock_quantity, $category, $image);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Custom CSS -->
    <link href="../../css/view_products.css" rel="stylesheet">
</head>
<body>
<div class="col-md-5">

        <h1 class="text-center mb-4">Your Products</h1>
        
        <div class="row">
            <?php while ($stmt->fetch()): ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <?php if ($image): ?>
                            <img src="../../uploads/<?php echo htmlspecialchars($image); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product_name); ?>">
                        <?php else: ?>
                            <img src="../../assets/images/product_default.jpg" class="card-img-top" alt="Default Image">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product_name); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($description); ?></p>
                            <p class="card-text"><strong>Price: </strong>$<?php echo htmlspecialchars($price); ?></p>
                           
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
                       
    <?php
    // Close the statement after the fetch loop
    $stmt->close();
    $conn->close();
    ?>
    
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>