<?php
session_start();
if (isset($_SESSION['restaurant_id'])) {
    echo $_SESSION['restaurant_id'];
} else {
    http_response_code(404);
    echo "No restaurant id found in session";
}
?>