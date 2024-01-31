<?php
// Include the database connection
include 'includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Management System</title>
    <link rel="stylesheet" href="css/style_index.css">
</head>
<body>
    <div class="container">
        <a href="pages/owner-login.php" class="login-option" id="owner-login">
                <p class="text-item">Owner</p>
            </a>
            <a href="pages/manager-login.php" class="login-option" id="manager-login">
                <p class="text-item">Manager</p>
            </a>
            <a href="pages/employee-login.php" class="login-option" id="employee-login">
           
                <p class="text-item">Employee</p>
            </a>
            <a href="pages/customer-login.php" class="login-option" id="customer-login">
                <p class="text-item">Customer</p>
            </a>
    </div>
</body>
</html>
