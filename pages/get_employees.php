<?php
    // Include the db.php file to get the database connection

include '../includes/db.php'; // Include the database connection script

$data = json_decode(file_get_contents('php://input'), true);
$restaurantId = $data['restaurant_id'];

// Query to retrieve restaurant data
$query = "SELECT * FROM employees WHERE fk1_id = :restaurantId";
$restaurantCount = 0;
function getCurrentType($id) {
    global $conn;

    $types = ['deliveryboy', 'cashier', 'cook'];

    foreach ($types as $type) {
        $stmt = $conn->prepare("SELECT employee_id FROM " . $type . " WHERE employee_id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            return strtolower($type);
        }
    }

    return null;
}
try {
    // Prepare the SQL statement
    $statement = $conn->prepare($query);
    $statement->bindParam(':restaurantId', $restaurantId);

    // Execute the prepared statement
    $statement->execute();

    // Fetch all rows as associative arrays
    $employees = $statement->fetchAll(PDO::FETCH_ASSOC);
    $employee_count = count($employees);
    foreach ($employees as $index => $employee) {
        $employees[$index]['type'] = getCurrentType($employee['employee_id']);
    }
    // Send the response as JSON
    echo json_encode($employees);
    
} catch (PDOException $e) {
    // Handle errors
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>