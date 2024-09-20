<?php
include '../confi/db_connection.php'; // Ensure the path is correct

// Fetch featured products
$products_query = "SELECT product_id, product_name, price, image FROM products LIMIT 4";
$products_result = $conn->query($products_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion E-Commerce</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/index.css">
</head>

<body>
<header>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">
                <img src="../../uploads/logo.png" alt="FashionSite Logo" class="logo"> <!-- Path to logo -->
                FashionSite
            </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../public/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../public/contact.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../auth/signup.php">Sign Up</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../auth/login.php">Login</a>
                </li>
            </ul>
        </div>
    </nav>
</header>


<section class="hero">
    <div class="container">
        <h1>Welcome to Fashion E-Commerce</h1>
        <p>Discover the latest trends in fashion.</p>
        <a href="../customer/view_products.php" class="btn btn-light btn-lg">Shop Now</a>


    </div>
        
</section>


    <!-- Featured Products -->
    <section class="featured-products py-5">
        <div class="container">
           
            <div class="row">
                <?php if ($products_result->num_rows > 0): ?>
                    <?php while ($product = $products_result->fetch_assoc()): ?>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <img src="../../uploads/<?php echo htmlspecialchars($product['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                                    <p class="card-text">$<?php echo htmlspecialchars($product['price']); ?></p>
                                    <a href="../customer/product_details.php?product_id=<?php echo $product['product_id']; ?>" class="btn btn-primary">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-center">No featured products available.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer Content -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            
            <p>&copy; 2024 FashionSite. All rights reserved.</p>
          
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Custom JS -->
    <script src="../js/index.js"></script>
</body>

</html>

<?php
// Close database connection
$conn->close();
?>
