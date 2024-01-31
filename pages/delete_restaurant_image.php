<?php
include '../includes/db.php';

$id = $_POST['id'];

// Define the image file path
$imageFilePath = "../r_images/{$id}.png";

// Check if the file exists
if (file_exists($imageFilePath)) {
    // Delete the file
    unlink($imageFilePath);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'File does not exist']);
}
?>