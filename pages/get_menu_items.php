<?php
include '../includes/db.php'; // Include the database connection script

$data = json_decode(file_get_contents('php://input'), true);
$restaurantId = $data['restaurant_id'];

// Query to retrieve menu items data
$query = "SELECT mi.*, CONCAT(e.firstname, ' ', e.lastname) as cook_name FROM menu_item mi 
          INNER JOIN cooks c ON mi.menu_item_id = c.FK2_menu_item_id
          INNER JOIN employees e ON c.FK1_employee_id = e.employee_id
          WHERE mi.fk1_menu_id = :restaurantId";
try {
    // Prepare the SQL statement
    $statement = $conn->prepare($query);
    $statement->bindParam(':restaurantId', $restaurantId);

    // Execute the prepared statement
    $statement->execute();

    // Fetch all rows as associative arrays
    $menuItems = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Send the response as JSON
    echo json_encode($menuItems);
    
} catch (PDOException $e) {
    // Handle errors
    echo "Error: " . $e->getMessage();
}

// Close the database connection
?>