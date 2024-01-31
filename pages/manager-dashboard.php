<?php
include '../includes/db.php';

session_start();
$restaurant_id = $_SESSION['restaurant_id'];
$stmt = $conn->prepare("SELECT e.employee_id, e.firstname AS firstName, e.lastname AS lastName FROM EMPLOYEES e INNER JOIN Cook c ON e.employee_id = c.employee_id WHERE e.FK1_id = ?");
$stmt->execute([$restaurant_id]);
$cooks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="../css/manager_dashboard.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <h1>Restaurant Manager</h1>
            </div>
        </nav>
    </header>

    <main>
        
        <section class="dashboard">
            <h2 class="welcome-message">Welcome, Manager!</h2>
            <button id="manage-employees-button" class="manage-button">Manage Employees</button>
            <button id="manage-menu-button" class="manage-button">Manage Menu</button>
            <img id="restaurant-image" alt="Restaurant Image">
            <h3 id="restaurant-name-details"></h3>
            <p id="restaurant-description"></p>
            <p id="restaurant-type"></p>
            <p>Number of employees: <span id="employee-count"></span></p>
            <p>Number of menu items: <span id="menu-item-count"></span></p>
        </section>
            <div id="hire-container" style="display: none;">
                <form id="hire-form" action="add_employee.php" method="post">
                    <label for="first-name">First Name:</label><br>
                    <input type="text" id="first-name" name="first_name"><br>
                    <label for="last-name">Last Name:</label><br>
                    <input type="text" id="last-name" name="last_name"><br>
                    <label for="salary">Salary:</label><br>
                    <input type="number" id="salary" name="salary"><br>
                    <label for="social-security">Social Security:</label><br>
                    <input type="text" id="social-security" name="social_security"><br>
                    <label for="job-title">Job Title:</label><br>
                    <select id="job-title" name="job_title">
                        <option value="Cashier">Cashier</option>
                        <option value="Deliveryboy">Deliveryboy</option>
                        <option value="Cook">Cook</option>
                    </select><br>
                    <input type="submit" value="Submit">
                </form>
            </div>
            <div id="employee-container" style="display: none;">
                <button class="button_new" id="hire-button">Hire New Employee</button>
                <br>
                <br>
                <div class="scrollable-table">

                <table id="employee-table" class="table-container">
                <thead>
                    <tr>    
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Salary</th>
                        <th>Social Security</th>
                        <th>Job</th>
                        <th>Employee ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                    <!-- Employee data will go here -->
                </table>
</div>
            </div>
            <div id="add-item-container" style="display: none;">
                <form id="add-item-form" action="add_menu_item.php" method="post">
                    <label for="item-name">Name:</label><br>
                    <input type="text" id="item-name" name="name"><br>
                    <label for="item-description">Description:</label><br>
                    <input type="text" id="item-description" name="description"><br>
                    <label for="item-price">Price:</label><br>
                    <input type="number" id="item-price" name="price" step="0.01" min="0"><br>
                    <label for="item-cook">Cook:</label><br>
                    <select id="item-cook" name="cook">
                        <?php foreach ($cooks as $cook) { ?>
                            <option value="<?php echo $cook['employee_id']; ?>"><?php echo $cook['firstname'] . ' ' . $cook['lastname']; ?></option>
                        <?php } ?>
                    </select><br>
                    <input type="submit" value="Submit">
                </form>
            </div>
            <div id="menu-container" style="display: none;">
            <button class="button_new" id="add-item-button">Add Menu Item</button>
            <br>
            <br>
            <table id="menu-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Cook</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <!-- Menu items will go here -->
            </table>
        </div>
    </main>
    <script src="/scripts/manager.js"></script>
    <script>
    // Log the restaurant id
    console.log('Restaurant ID from PHP:', <?php echo $restaurant_id; ?>);

    // Call the function with the restaurant id
    showRestaurantDetails(<?php echo $restaurant_id; ?>);
</script>

</body>
</html>
