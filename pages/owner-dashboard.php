<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard</title>
    <link rel="stylesheet" href="/css/owner_dashboard.css">
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
            <h2>Welcome, Owner!</h2>
            <p>You currently manage <span id="restaurant-count"></span> restaurants.</p>
                </section>
    </main>
    <div class="container">
        <div class="restaurant-list">
            <h2>Restaurant List</h2>
            <!-- Add New Restaurant Button -->
            <button id="add-restaurant-button" class="add-button">Add New Restaurant</button>
            <div class="table-container">
            <table id="restaurant-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Cuisine</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="restaurant-list-body">
                    <!-- Restaurant entries will be dynamically added here -->
                </tbody>
            </table>
            </div>
        </div>
        <div class="restaurant-details">
            <h2>Restaurant Details</h2>
            <!-- Add New Restaurant Form -->
            <div id="edit-restaurant-form" style="display: none;">
                <form action="edit_restaurant.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="edit-id" name="id">
                    <label for="edit-name">Name:</label><br>
                    <input type="text" id="edit-name" name="name" required><br>
                    <label for="edit-description">Description:</label><br>
                    <input type="text" id="edit-description" name="description" required><br>
                    <label for="edit-type">Type:</label><br>
                    <select id="edit-type" name="type" required>
                        <option value="">Select a cuisine</option>
                        <option value="sushi">Sushi</option>
                        <option value="chinese">Chinese</option>
                        <option value="italian">Italian</option>
                        <option value="vegan">Vegan</option>
                        <option value="mexican">Mexican</option>
                    </select>
                    <br>
                    <br>
                    <label for="edit-isactive">Active:</label>
                    <input type="checkbox" id="edit-isactive" name="isactive">
                    <div id="edit-drop-zone">
                        <p id="edit-drop-text">Drag and drop an image here, or click to select an image.</p>
                        <input type="file" id="edit-file-input" name="image" style="display: none;">
                        <img id="edit-preview" style="display: none; max-width: 100%; max-height: 100%;">
                        <button id="edit-delete_image_Button" style="display: none;">X</button>
                    </div>
                    <input type="submit" value="Submit">
                </form>
            </div>
            <div id="add-restaurant-form" style="display: none;">
            <form action="add_restaurant.php" method="post" enctype="multipart/form-data">
                <label for="name">Name:</label><br>
                <input type="text" id="name" name="name" required><br>
                <label for="description">Description:</label><br>
                <input type="text" id="description" name="description" required><br>
                <label for="type">Type:</label><br>
                <select id="type" name="type" required>
                    <option value="">Select a cuisine</option>
                    <option value="sushi">Sushi</option>
                    <option value="chinese">Chinese</option>
                    <option value="italian">Italian</option>
                    <option value="vegan">Vegan</option>
                    <option value="mexican">Mexican</option>
                </select>
                    <br>
                    <br>
                <label for="isactive">Active:</label>
                <input type="checkbox" id="isactive" name="isactive">
                <div id="drop-zone">
                    <p id="drop-text">Drag and drop an image here, or click to select an image.</p>
                    <input type="file" id="file-input" name="image" style="display: none;">
                    <img id="preview" style="display: none; max-width: 100%; max-height: 100%;">
                    <button id="delete_image_Button" style="display: none;">X</button>
                </div>
                <input type="submit" value="Submit">
            </form>
            </div>
            <div id="restaurant-details-container">
                <div id="restaurant-image-container">
                <!-- Restaurant image will be dynamically added here -->
         </div>

            </form>
        </div>
    </div>
            </div>
        </div>
    </div>
    <footer>
        <!-- Add footer content here (e.g., copyright information) -->
        <p>&copy; Kati Kaigetai Management System</p>
    </footer>
    <script src="/scripts/dashboard_script.js"></script>
    <script>
</script>
</body>
</html>


