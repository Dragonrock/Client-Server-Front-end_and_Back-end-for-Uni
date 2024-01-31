<?php
session_start();

// Include the database connection
include '../includes/db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $restaurant_id = $_POST['restaurant_id'];

    // Query the database
    $stmt = $conn->prepare("SELECT id FROM restaurant WHERE id = ? AND isActive = ?");
    $stmt->execute([$restaurant_id, true]);

    // Check if the restaurant ID exists
    if ($stmt->rowCount() > 0) {
        $_SESSION['restaurant_id'] = $restaurant_id;
        // Redirect to the manager dashboard
        header('Location: manager-dashboard.php');
        exit;
    } else {
        $error_message = "Invalid or inactive restaurant ID.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Management System</title>
    <link rel="stylesheet" href="../css/login-manager.css">
</head>
<body>
    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="restaurant_id">Enter your restaurant ID:</label>
            <input type="text" id="restaurant_id" name="restaurant_id" required>
            <input type="submit" value="Submit">
        </form>
        <?php if (!empty($error_message)) echo "<p>$error_message</p>"; ?>
    </div>
</body>
</html>