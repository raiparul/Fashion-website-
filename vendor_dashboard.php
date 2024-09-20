<?php
session_start();


if (!isset($_SESSION['id']) || $_SESSION['usertype'] !== 'vendor') {
    header("Location: ../auth/login.php");
    exit();
}

include '../confi/db_connection.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/vendor_dashboard.css">
</head>
<body>
    <div class="container mt-5">
        <header class="dashboard-header">
            
            <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        </header>
        <p>This is your vendor dashboard.</p>
        <!-- Add links or sections for managing products, viewing orders, etc. -->
        <a href="manage_products.php" class="btn btn-primary"><i class="fa fa-box"></i> Manage Products</a>
        <a href="manage_orders.php" class="btn btn-secondary"><i class="fa fa-list"></i> View Orders</a>
        <a href="../auth/logout.php" class="btn btn-danger"><i class="fa fa-sign-out-alt"></i> Logout</a>
    </div>
    <script src="../../js/vendor_dashboard.js"></script>

</body>
</html>
