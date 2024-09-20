<?php
include '../confi/db_connection.php';

session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['id']) || $_SESSION['usertype'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Example: Update site settings
    if (isset($_POST['site_name'])) {
        $site_name = $_POST['site_name'];
        $site_description = $_POST['site_description'];

        $update_query = "UPDATE site_settings SET site_name = ?, site_description = ? WHERE id = 1";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ss", $site_name, $site_description);
        $stmt->execute();
        $stmt->close();
    }

    // Handle other form submissions such as enabling/disabling features
    // Example: Update feature status
    // if (isset($_POST['feature_status'])) {
    //     $feature_status = $_POST['feature_status'];
    //     $update_feature_query = "UPDATE features SET status = ? WHERE feature_id = 1";
    //     $stmt = $conn->prepare($update_feature_query);
    //     $stmt->bind_param("s", $feature_status);
    //     $stmt->execute();
    //     $stmt->close();
    // }

    header("Location: manage_site.php");
    exit();
}

// Fetch current site settings
$settings_query = "SELECT * FROM site_settings WHERE id = 1";
$result = $conn->query($settings_query);
$settings = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Site</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Manage Site</h1>

        <!-- Example site management form -->
        <form action="manage_site.php" method="post">
            <div class="form-group">
                <label for="site_name">Site Name:</label>
                <input type="text" id="site_name" name="site_name" class="form-control" value="<?= htmlspecialchars($settings['site_name']) ?>" required>
            </div>
            <div class="form-group">
                <label for="site_description">Site Description:</label>
                <textarea id="site_description" name="site_description" class="form-control" rows="3" required><?= htmlspecialchars($settings['site_description']) ?></textarea>
            </div>
            <!-- Add other settings or features here -->
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>

        <a href="dashboard.php" class="btn btn-secondary mt-3">Back to Dashboard</a>
    </div>
    <script src="../../js/manage_site.js" defer></script>
</body>
</html>
