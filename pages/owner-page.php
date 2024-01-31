<?php
// Check if the password is provided
if(isset($_POST['password'])) {
    $password = $_POST['password'];

    // Validate the password (You need to implement this part)
    if(validatePassword($password)) {
        // Redirect to the owner's page
        header("Location: owner-dashboard.php");
        exit();
    } else {
        // If password is incorrect, show an error message
        echo "Invalid password";
    }
} else {
    // If password is not provided, redirect back to the login page
    header("Location: owner-login.php");
    exit();
}

// Function to validate the password (Replace this with your actual validation logic)
function validatePassword($password) {
    // Your validation logic here (e.g., checking against a stored password)
    // Return true if password is valid, false otherwise
    return $password === "lefta";
}
?>
