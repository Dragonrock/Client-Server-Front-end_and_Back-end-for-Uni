<?php
include '../includes/db.php'; // Include the database connection script
function getCurrentType($id) {
    global $conn;

    $types = ['SUSHI', 'CHINESE', 'ITALIAN', 'VEGAN', 'MEXICAN'];

    foreach ($types as $type) {
        $stmt = $conn->prepare("SELECT id FROM " . $type . " WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            return strtolower($type);
        }
    }

    return null;
}
// Query to retrieve restaurant data
$query = "SELECT id, name, description, isActive FROM restaurant";
$restaurantCount = 0;

try {
    // Prepare the SQL statement
    $statement = $conn->prepare($query);
    
    // Execute the prepared statement
    $statement->execute();

    // Fetch all rows as associative arrays
    $restaurants = $statement->fetchAll(PDO::FETCH_ASSOC);
    $restaurantCount = count($restaurants);

    // Add the type to each restaurant
    foreach ($restaurants as &$restaurant) {
        $restaurant['type'] = getCurrentType($restaurant['id']);
    }

    // Send the response as JSON
    echo json_encode($restaurants);
    
} catch (PDOException $e) {
    // Handle errors
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>