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
$restaurantId = $_GET['id'];

// Query to retrieve restaurant details
$query = "SELECT * FROM restaurant WHERE id = :id";

try {
    // Prepare the SQL statement
    $statement = $conn->prepare($query);
    
    // Bind the restaurantId parameter to the SQL statement
    $statement->bindValue(':id', $restaurantId);
    
    // Execute the prepared statement
    $statement->execute();

    // Fetch the row as an associative array
    $restaurantDetails = $statement->fetch(PDO::FETCH_ASSOC);
    // Get the current type of the restaurant
    $currentType = getCurrentType($restaurantId);

    // Add the type to the restaurant details
    $restaurantDetails['type'] = $currentType;

    // Query to calculate the sum of all the order costs
    $queryProfit = "SELECT SUM(cost) AS profit FROM orders WHERE FK1_id = :id";

    // Prepare the SQL statement
    $statementProfit = $conn->prepare($queryProfit);

    // Bind the restaurantId parameter to the SQL statement
    $statementProfit->bindValue(':id', $restaurantId);

    // Execute the prepared statement
    $statementProfit->execute();

    // Fetch the row as an associative array
    $profitDetails = $statementProfit->fetch(PDO::FETCH_ASSOC);

    // Add the profit to the restaurant details
    $restaurantDetails['profit'] = $profitDetails['profit'];


    // Query to calculate the sum of all the salaries of all employees
    $queryExpenses = "SELECT SUM(salary) AS expenses FROM employees WHERE fK1_id = :id";

    // Prepare the SQL statement
    $statementExpenses = $conn->prepare($queryExpenses);

    // Bind the restaurantId parameter to the SQL statement
    $statementExpenses->bindValue(':id', $restaurantId);

    // Execute the prepared statement
    $statementExpenses->execute();

    // Fetch the row as an associative array
    $expensesDetails = $statementExpenses->fetch(PDO::FETCH_ASSOC);

    // Add the expenses to the restaurant details
    $restaurantDetails['expenses'] = $expensesDetails['expenses'];

    $queryEmployeeCount = "SELECT COUNT(*) AS employeeCount FROM employees WHERE fK1_id = :id";

    // Prepare the SQL statement
    $statementEmployeeCount = $conn->prepare($queryEmployeeCount);
    
    // Bind the restaurantId parameter to the SQL statement
    $statementEmployeeCount->bindValue(':id', $restaurantId);
    
    // Execute the prepared statement
    $statementEmployeeCount->execute();
    
    // Fetch the row as an associative array
    $employeeCountDetails = $statementEmployeeCount->fetch(PDO::FETCH_ASSOC);
    
    // Check if the result is an array and set the employee count accordingly
    $restaurantDetails['employeeCount'] = $employeeCountDetails['employeecount'];

    
    // Query to calculate the number of menu items
    $queryMenuItemCount = "SELECT COUNT(*) AS menuItemCount FROM MENU_ITEM WHERE fk1_menu_id = (SELECT fK1_menu_id FROM RESTAURANT WHERE id = :id)";
    
    // Prepare the SQL statement
    $statementMenuItemCount = $conn->prepare($queryMenuItemCount);
    
    // Bind the restaurantId parameter to the SQL statement
    $statementMenuItemCount->bindValue(':id', $restaurantId);
    
    // Execute the prepared statement
    $statementMenuItemCount->execute();
    
    // Fetch the row as an associative array
    $menuItemCountDetails = $statementMenuItemCount->fetch(PDO::FETCH_ASSOC);
    
    $restaurantDetails['menuItemCount'] = $menuItemCountDetails['menuitemcount'];
    // Send the response as JSON




    echo json_encode($restaurantDetails);
    
} catch (PDOException $e) {
    // Handle errors
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>