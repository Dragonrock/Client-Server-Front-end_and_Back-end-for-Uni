<?php
include '../includes/db.php'; // Include the database connection script

// Check if the id is provided
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Prepare a delete statement
    $stmt = $conn->prepare("DELETE FROM restaurant WHERE id = :id");

    // Bind the id to the delete statement
    $stmt->bindValue(':id', $id);

    // Execute the delete statement
    try {
        $stmt->execute();

        // If the delete was successful, send a success response
        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        // If the delete failed, send an error response
        echo json_encode(['status' => 'error', 'message' => 'Could not delete restaurant. Error: ' . $e->getMessage()]);
    }
} else {// If no id was provided, send an error response
    echo json_encode(['status' => 'error', 'message' => 'No restaurant id provided.']);
}

// Close the database connection
$conn = null;
?>