<?php
include '../confi/db_connection.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $result = $conn->query("SELECT * FROM products WHERE product_name LIKE '%$query%' OR description LIKE '%$query%'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Fashion E-Commerce</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>

    <div class="container mt-5">
        <h2>Search Results for "<?= htmlspecialchars($query) ?>"</h2>
        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-md-3">';
                    echo '<div class="card">';
                    echo '<img src="assets/images/' . $row['image'] . '" alt="' . $row['product_name'] . '" class="card-img-top">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['product_name'] . '</h5>';
                    echo '<p class="card-text">$' . $row['price'] . '</p>';
                    echo '<a href="php/customer/product_details.php?id=' . $row['product_id'] . '" class="btn btn-primary">View Details</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No results found for your search query.</p>';
            }

            $conn->close();
            ?>
        </div>
    </div>

    <?php include 'templates/footer.php'; ?>
</body>
</html>
