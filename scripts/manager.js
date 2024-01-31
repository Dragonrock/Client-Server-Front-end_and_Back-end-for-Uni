function showRestaurantDetails(restaurant_id) {
    console.log('Restaurant ID:', restaurant_id); // Log the restaurant ID

    fetch(`get_restaurant_details.php?id=${restaurant_id}`)
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text(); // Get the server response as text
    })
    .then(text => {
        console.log('Server response:', text); // Log the server response
        var data = JSON.parse(text); // Parse the server response as JSON

            // Construct the image URL using the restaurant id and the known folder path
            var imageUrl = `http://localhost/r_images/${restaurant_id}.png`; // Assuming the images are in png format
            console.log('Image URL:', imageUrl); // Log the Image URL

            // Update the page with the data
            document.getElementById('restaurant-image').src = imageUrl;
            document.getElementById('restaurant-name-details').textContent = data.name;
            document.getElementById('restaurant-description').textContent = data.description;
            document.getElementById('restaurant-type').textContent = data.type;
            document.getElementById('employee-count').textContent = data.employeeCount;
            document.getElementById('menu-item-count').textContent = data.menuItemCount;
        })
        .catch(error => console.error('Error:', error));
}

document.getElementById('manage-employees-button').addEventListener('click', function() {
    var employeeContainer = document.getElementById('employee-container');
    var menuContainer = document.getElementById('menu-container');
    var formContainer = document.getElementById('add-item-container');

        if (employeeContainer.style.display === "none") {
            console.log('Showing employee container');
            formContainer.style.display = "none";
            menuContainer.style.display = "none";
            employeeContainer.style.display = "block";
        } else {
            console.log('Hiding employee container');
            employeeContainer.style.display = "none";
        }
        addEventListeners();
    fetch('get_restaurant_id.php')
    .then(response => response.text())
    .then(restaurant_id => {
    fetch('get_employees.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            restaurant_id: restaurant_id
        }),
    })
    .then(response => response.json())
    .then(data => {
            // Populate the employee table with the data
            var employeeTable = document.getElementById('employee-table');
            while (employeeTable.rows.length > 1) { // keep the first row, which is likely the header
                employeeTable.deleteRow(1);
            }

            data.forEach(employee => {
                var row = employeeTable.insertRow();
                var firstNameCell = row.insertCell();
                var lastNameCell = row.insertCell();
                var salaryCell = row.insertCell();
                var socialSecurityCell = row.insertCell();
                var jobTitleCell = row.insertCell();
                var employeeIdCell = row.insertCell();
                var fireButtonCell = row.insertCell();
                
                firstNameCell.textContent = employee.firstname;
                lastNameCell.textContent = employee.lastname;
                salaryCell.textContent = employee.salary;
                socialSecurityCell.textContent = employee.social_security;
                jobTitleCell.textContent = employee.type;
                employeeIdCell.textContent = employee.employee_id;
                var fireButton = document.createElement('button');
                fireButton.textContent = 'Fire';
                // Create a select element
                var jobTitleSelect = document.createElement('select');
                jobTitleSelect.className = 'job-title-select';
                // Add the job titles as options
                ['cook', 'deliveryboy', 'cashier'].forEach(jobTitle => {
                    var option = document.createElement('option');
                    option.value = jobTitle;
                    option.textContent = jobTitle;
                    if (jobTitle === employee.type) {
                        option.selected = true;
                        console.log('Selected option:', option);
                        console.log('Job Title: ',jobTitle);
                    }
                    jobTitleSelect.appendChild(option);
                });

                // Replace the job title cell with the select element
                jobTitleCell.textContent = '';
                jobTitleCell.appendChild(jobTitleSelect);

                // Add an event listener to the change event
                jobTitleSelect.addEventListener('change', function() {
                    // Get the new job title
                    var newJobTitle = this.value;

                    // Make a request to the server to update the job title
                    fetch('update_job.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            id: employee.employee_id,
                            jobTitle: newJobTitle
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            console.error('Failed to update job title');
                        }
                    });
                });

                fireButton.addEventListener('click', function() {
                    // Fire the employee when the button is clicked
                    fetch('fire_employee.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            id: employee.employee_id
                        }),
                    })
                    .then(response => {
                        if (response.ok) {
                            // Remove the row from the table
                            row.remove();
                        } else {
                            console.error('Failed to fire employee');
                        }
                    });
                });

                fireButtonCell.appendChild(fireButton);
            });
        });
    });
});
document.getElementById('hire-button').addEventListener('click', function() {
    var hireContainer = document.getElementById('hire-container');
    var menuContainer = document.getElementById('menu-container');

    if (hireContainer.style.display === "none") {
        console.log('Showing hire container');
        menuContainer.style.display = "none";
        hireContainer.style.display = "block";
    } else {
        console.log('Hiding hire container');
        hireContainer.style.display = "none";
    }
});

document.getElementById('manage-menu-button').addEventListener('click', function() {
    var menuContainer = document.getElementById('menu-container');
    var employeeContainer = document.getElementById('employee-container');
    var hireContainer = document.getElementById('hire-container');

    if (menuContainer.style.display === "none") {
        console.log('Showing menu container');
        employeeContainer.style.display = "none";
        hireContainer.style.display = "none";
        menuContainer.style.display = "block";
            
        fetch('get_restaurant_id.php')
        .then(response => response.text())
        .then(restaurant_id => {
            fetch('get_menu_items.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    restaurant_id: restaurant_id
                }),
            })
            .then(response => response.json())
            .then(data => {
                // Populate the menu table with the data
                var menuTable = document.getElementById('menu-table');
                while (menuTable.rows.length > 1) { // keep the first row, which is likely the header
                    menuTable.deleteRow(1);
                }

                data.forEach(menuItem => {
                    var row = menuTable.insertRow();
                    var nameCell = row.insertCell();
                    var descriptionCell = row.insertCell();
                    var priceCell = row.insertCell();
                    var cookCell = row.insertCell();
                    var removeButtonCell = row.insertCell();
                
                    nameCell.textContent = menuItem.name;
                    descriptionCell.textContent = menuItem.description;
                    priceCell.textContent = menuItem.price;
                    cookCell.textContent = menuItem.cook_name; // Assuming 'cook' is the name of the property that contains the cook's name
                
                    var removeButton = document.createElement('button');
                    removeButton.textContent = 'Remove';
                    removeButton.addEventListener('click', function() {
                        // Remove the menu item when the button is clicked
                        fetch('remove_menu_item.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                menu_item_id: menuItem.menu_item_id //
                            }),
                        })
                        .then(response => response.text())
                        .then(data => {
                            console.log(data);

                            this.parentNode.parentNode.remove();
                        });
                    });
                
                    removeButtonCell.appendChild(removeButton);
                });
            });
        });
    } else {
        console.log('Hiding menu container');
        menuContainer.style.display = "none";
    }
});
function addEventListeners() {
    // Get the table body
    var tableBody = document.getElementById('employee-list-body');
    if (!tableBody) {
        console.log('Table body does not exist yet');
        return;
    }
    // Get all the rows in the table body
    var rows = tableBody.getElementsByTagName('tr');

    // Loop through each row
    for (var i = 0; i < rows.length; i++) {
        // Get the change and fire buttons in the row
        var changeButton = rows[i].querySelector('.change-button');
        var fireButton = rows[i].querySelector('.fire-button');

        // Remove existing event listeners
        changeButton.removeEventListener('click', changeButtonClickHandler);
        fireButton.removeEventListener('click', fireButtonClickHandler);

        // Add new event listeners
        changeButton.addEventListener('click', changeButtonClickHandler);
        fireButton.addEventListener('click', fireButtonClickHandler);
    }
}

function changeButtonClickHandler(event) {
    event.stopPropagation(); // Prevent the row click event from firing
    var employeeId = this.getAttribute('data-id');

    // Handle the change button click event
    // This might involve showing a form to change the employee's job type
}

function fireButtonClickHandler() {
    var employeeId = this.getAttribute('data-id');
    console.log(employeeId)
    // Make a POST request to the fire script
    fetch('fire_employee.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ 'id': employeeId }),
    })
    // Handle the response here
}

var manageEmployeesButton = document.getElementById('manage-employees-button');
var manageMenuButton = document.getElementById('manage-menu-button');

var employeeContainer = document.getElementById('employee-container');
var menuContainer = document.getElementById('menu-container');



manageMenuButton.onclick = function() {
    console.log('Manage Menu button clicked');

    if (menuForm.style.display === "none") {
        console.log('Showing menu form');
        menuForm.style.display = "block";
    } else {
        console.log('Hiding menu form');
        menuForm.style.display = "none";
    }
    addEventListeners();
}

document.getElementById('add-item-button').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the form from being submitted normally

    // Get the form container
    var formContainer = document.getElementById('add-item-container');

    // Toggle the display property of the form container
    if (formContainer.style.display === 'none') {
        formContainer.style.display = 'block';
    } else {
        formContainer.style.display = 'none';
    }
});