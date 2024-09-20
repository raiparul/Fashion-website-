<?php
include '../confi/db_connection.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id, password, usertype FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $usertype);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['usertype'] = $usertype;

            // Redirect based on user type
            if ($usertype == "vendor") {
                header("Location: ../vendor/vendor_dashboard.php");
            } elseif ($usertype == "customer") {
                header("Location: ../customer/customer_dashboard.php");
            } elseif ($usertype == "admin") {
                header("Location: ../superadmin/dashboard.php"); // Redirect to admin dashboard
            } else {
                $error = "Unknown user type!";
            }
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "No user found with that username!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Fashion E-Commerce</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Login</h2>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>
                        <form action="login.php" method="post">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                        <p class="mt-3">Don't have an account? <a href="signup.php">Sign up here</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../../js/login.js" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
