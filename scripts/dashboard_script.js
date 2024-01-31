// Ideas : pagination for list of restaurants and search bar

document.addEventListener("DOMContentLoaded", function () {
    
    // Fetch restaurant data and populate the table
    fetch('get_restaurants.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(JSON.stringify(data, null, 2)); // Pretty print the JSON data
            populateRestaurantTable(data);
            addEventListeners();
        })
        .catch(error => console.error('Error:', error));
        
    
    function populateRestaurantTable(restaurants) {
        if (!restaurants) {
            console.error('No data received from the server');
            return;
        }
        const restaurantCount = restaurants.length;
        // Display the restaurant count
        document.getElementById('restaurant-count').textContent = restaurantCount;

        const tableBody = document.getElementById('restaurant-list-body');
        tableBody.innerHTML = '';
        restaurants.forEach(restaurant => {

            const row = document.createElement('tr');
            row.className = 'clickable-row unselectable';
            row.setAttribute('data-id', restaurant.id);
            row.innerHTML = `
                <td>${restaurant.name}</td>
                <td>${restaurant.type}</td> <!-- Display the restaurant type -->
                <td>${restaurant.isactive == true ? 'Active' : 'Inactive'}</td>

                <td>
                    <div style="display: flex; justify-content: center;">
                        <button class="edit-button" data-id="${restaurant.id}">Edit</button>
                        <button class="delete-button" data-id="${restaurant.id}">Delete</button>
                    </div>
                </td>
            `;
                    
            tableBody.appendChild(row);
})};
});

function showRestaurantDetails(restaurantId) {
    console.log('Restaurant ID:', restaurantId); // Log the restaurant ID

    fetch(`get_restaurant_details.php?id=${restaurantId}`)
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
            var imageUrl = `http://localhost/r_images/${restaurantId}.png`; // Assuming the images are in jpg format
            console.log('Image URL:', imageUrl); // Log the Image URL
            populateRestaurantImage(imageUrl, data, restaurantId);
            
        })
        .catch(error => console.error('Error:', error));
}

function hideRestaurantDetails() {
    // Get the restaurant details container
    var restaurantDetailsContainer = document.getElementById('restaurant-details-container');

    // Hide the restaurant details container
    restaurantDetailsContainer.style.display = 'none';
}

function populateRestaurantImage(imageUrl, data, id) {
    var imageContainer = document.getElementById('restaurant-image-container');
    var image = document.createElement('img'); // Create an 'img' element
    image.src = imageUrl;
    image.style.width = '100%'; // Set the image width
    image.style.height = 'auto'; // Set the image height
    
    var name = document.createElement('p');
    name.textContent = `Name: ${data.name}`;
    name.style.fontWeight = 'bold'; // Make the name bold
    name.style.fontSize = '20px'; // Increase the font size
    
    var description = document.createElement('p');
    description.textContent = `Description: ${data.description}`;
    description.style.marginTop = '10px'; // Add some top margin
    
    var profit = document.createElement('p');
    profit.textContent = `Profit: ${data.profit}€`;
    profit.style.color = 'green'; // Make the profit green
    
    var expenses = document.createElement('p');
    expenses.textContent = `Expenses: ${data.expenses}€`;
    expenses.style.color = 'red'; // Make the expenses red

    var id_show = document.createElement('p');
    id_show.textContent = `ID: ${id}`;
    id_show.style.color = 'black'; 
    
    imageContainer.innerHTML = ''; // Clear the existing content
    imageContainer.style.padding = '20px'; // Add some padding
    imageContainer.style.border = '1px solid #ccc'; // Add a border
    imageContainer.style.borderRadius = '5px'; // Add some border radius
    imageContainer.style.backgroundColor = '#f9f9f9'; // Change the background color
    
    imageContainer.appendChild(name); // Add the name
    imageContainer.appendChild(image); // Add the new image
    imageContainer.appendChild(description); // Add the description
    imageContainer.appendChild(profit); // Add the profit
    imageContainer.appendChild(expenses); // Add the expenses
    imageContainer.appendChild(id_show); // Add the id
}


// Get the button that shows the form
var btn = document.getElementById("add-restaurant-button");

// Get the form
var form = document.getElementById("add-restaurant-form");

// When the user clicks the button, show or hide the form
btn.onclick = function() {
    console.log('Button clicked'); // Log when the button is clicked

    var editForm = document.getElementById('edit-restaurant-form');
    console.log(editForm); // Log the edit form

    if (form.style.display === "none") {
        console.log('Showing form'); // Log when the form is shown
        form.style.display = "block";
        hideRestaurantDetails();
        if (editForm) {
            editForm.style.display = 'none'; // Hide the edit form
        }
    } else {
        console.log('Hiding form'); // Log when the form is hidden
        form.style.display = "none";
    }
    addEventListeners();
}
function addEventListeners() {
    // Get the table body
    var tableBody = document.getElementById('restaurant-list-body');

    // Get all the rows in the table body
    var rows = tableBody.getElementsByTagName('tr');

 // Loop through each row
    for (var i = 0; i < rows.length; i++) {
        // Get the edit and delete buttons in the row
        var editButton = rows[i].querySelector('.edit-button');
        var deleteButton = rows[i].querySelector('.delete-button');

        // Remove existing event listeners
        rows[i].removeEventListener('click', rowClickHandler);
        editButton.removeEventListener('click', editButtonClickHandler);
        deleteButton.removeEventListener('click', deleteButtonClickHandler);

        // Add new event listeners
        rows[i].addEventListener('click', rowClickHandler);
        editButton.addEventListener('click', editButtonClickHandler);
        deleteButton.addEventListener('click', deleteButtonClickHandler);
    }
}


function deleteButtonClickHandler(event) {
    event.stopPropagation(); // Prevent the row click event from firing
    var restaurantId = this.getAttribute('data-id');

    // Make a POST request to the delete script
    fetch('delete_restaurant.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ 'id': restaurantId }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // If the delete was successful, remove the row from the table
            this.parentElement.parentElement.parentElement.remove();

            // Delete the image
            fetch('delete_restaurant_image.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({ 'id': restaurantId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status !== 'success') {
                    // If the image deletion was not successful, log the error message
                    console.error('Error:', data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        } else {
            // If the delete was not successful, log the error message
            console.error('Error:', data.message);
        }
    })
    .catch(error => console.error('Error:', error));

    hideRestaurantDetails();
    var editForm = document.getElementById('edit-restaurant-form');
    editForm.style.display = 'none';
    form.style.display = "none";
}

// Define the event handlers
function rowClickHandler() {
    form.style.display = "none";
    var editForm = document.getElementById('edit-restaurant-form');
    editForm.style.display = 'none';
    var restaurantDetailsContainer = document.getElementById('restaurant-details-container');

    restaurantDetailsContainer.style.display = "block"; 

    showRestaurantDetails(this.getAttribute('data-id')); // Call the function when a row is clicked
    
    // Hide the "Add New Restaurant" form
}

function editButtonClickHandler(event) {
    event.stopPropagation(); // Prevent the row click event from firing
    var restaurantId = this.getAttribute('data-id');

    // Fetch the restaurant data
    fetch(`get_restaurant_details.php?id=${restaurantId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Get the edit form elements
            var editForm = document.getElementById('edit-restaurant-form');
            var editId = document.getElementById('edit-id');
            var editName = document.getElementById('edit-name');
            var editDescription = document.getElementById('edit-description');
            var editIsActive = document.getElementById('edit-isactive');
            var editType = document.getElementById('edit-type');
            // Populate the form with the restaurant data
            editId.value = data.id;
            editName.value = data.name;
            editDescription.value = data.description;
            editIsActive.checked = data.isactive;
            editType.value = data.type;
            
            // Show the edit form
            editForm.style.display = 'block';
            form.style.display = "none"; // Hide the add new restaurant form
        })
        .catch(error => console.error('Error:', error));
        
    // Hide the "Add New Restaurant" form
    hideRestaurantDetails();
}
var dropZone = document.getElementById('drop-zone');
var fileInput = document.getElementById('file-input');
var preview = document.getElementById('preview');
var delete_image_Button = document.getElementById('delete_image_Button');
var dropText = document.getElementById('drop-text');
var editDropZone = document.getElementById('edit-drop-zone');
var editFileInput = document.getElementById('edit-file-input');
var editPreview = document.getElementById('edit-preview');
var editDeleteButton = document.getElementById('edit-delete_image_Button');

function updatePreviewEdit(file) {
    var reader = new FileReader();
    reader.onloadend = function() {
        editPreview.src = reader.result;
        editPreview.style.display = 'block';
        editDeleteButton.style.display = 'block';
        editDropZone.classList.add('has-image');
    }
    reader.readAsDataURL(file);
}

function clearPreviewEdit() {
    var imageInput = document.getElementById('edit-file-input');
    var imagePreview = document.getElementById('edit-preview');

    imageInput.value = '';
    imagePreview.src = '';
    imagePreview.style.display = 'none';

    editDropZone.classList.remove('has-image');

    imageInput.disabled = true;
    setTimeout(function() {
        imageInput.disabled = false;
    }, 200);

    document.getElementById('edit-delete_image_Button').style.display = 'none';
}

editDropZone.addEventListener('dragover', function(e) {
    e.preventDefault();
});

editDropZone.addEventListener('drop', function(e) {
    e.preventDefault();
    if (e.dataTransfer.items) {
        for (var i = 0; i < e.dataTransfer.items.length; i++) {
            if (e.dataTransfer.items[i].kind === 'file') {
                var file = e.dataTransfer.items[i].getAsFile();
                editFileInput.files = e.dataTransfer.files;
                updatePreviewEdit(file);
            } else if (e.dataTransfer.items[i].kind === 'string') {
                e.dataTransfer.items[i].getAsString(function(s) {
                    if (s.startsWith('http://') || s.startsWith('https://')) {
                        editPreview.src = s;
                        editPreview.style.display = 'block';
                        editDeleteButton.style.display = 'block';
                        editDropZone.classList.add('has-image');
                    }
                });
            }
        }
    }
});

editDropZone.addEventListener('click', function() {
    editFileInput.click();
});

window.addEventListener('paste', function(e) {
    if (e.clipboardData.items) {
        for (var i = 0; i < e.clipboardData.items.length; i++) {
            if (e.clipboardData.items[i].kind === 'file') {
                var file = e.clipboardData.items[i].getAsFile();
                editFileInput.files = e.clipboardData.files;
                updatePreviewEdit(file);
            }
        }
    }
});

editFileInput.addEventListener('change', function(e) {
    if (editFileInput.files.length > 0) {
        updatePreviewEdit(editFileInput.files[0]);
    }
});

editDeleteButton.addEventListener('click', function(e) {
    e.preventDefault();
    clearPreviewEdit();
});
function updatePreview(file) {
    var reader = new FileReader();
    reader.onloadend = function() {
        preview.src = reader.result;
        preview.style.display = 'block';
        delete_image_Button.style.display = 'block';
        dropZone.classList.add('has-image'); // Add the has-image class
    }
    reader.readAsDataURL(file);
}

function clearPreview() {
    // Get the image input and preview elements
    var imageInput = document.getElementById('file-input');
    var imagePreview = document.getElementById('preview');

    // Reset the image input and preview
    imageInput.value = '';
    imagePreview.src = '';
    imagePreview.style.display = 'none';

    // Remove the has-image class
    dropZone.classList.remove('has-image');

    // Disable the file input for 1 second
    imageInput.disabled = true;
    setTimeout(function() {
        imageInput.disabled = false;
    }, 200);

    // Hide the delete button
    document.getElementById('delete_image_Button').style.display = 'none';
}
// Handle the dragover event
dropZone.addEventListener('dragover', function(e) {
    e.preventDefault();
});

// Handle the drop event
dropZone.addEventListener('drop', function(e) {
    e.preventDefault();
    if (e.dataTransfer.items) {
        // Use DataTransferItemList interface to access the file(s)
        for (var i = 0; i < e.dataTransfer.items.length; i++) {
            if (e.dataTransfer.items[i].kind === 'file') {
                var file = e.dataTransfer.items[i].getAsFile();
                fileInput.files = e.dataTransfer.files;
                updatePreview(file);
            } else if (e.dataTransfer.items[i].kind === 'string') {
                e.dataTransfer.items[i].getAsString(function(s) {
                    if (s.startsWith('http://') || s.startsWith('https://')) {
                        preview.src = s;
                        preview.style.display = 'block';
                        deleteButton.style.display = 'block';
                        dropZone.classList.add('has-image');
                    }
                });
            }
        }
    }
});

// Handle the click event
dropZone.addEventListener('click', function() {
    fileInput.click();
});

// Handle the paste event
window.addEventListener('paste', function(e) {
    if (e.clipboardData.items) {
        // Use ClipboardItemList interface to access the file(s)
        for (var i = 0; i < e.clipboardData.items.length; i++) {
            if (e.clipboardData.items[i].kind === 'file') {
                var file = e.clipboardData.items[i].getAsFile();
                fileInput.files = e.clipboardData.files;
                updatePreview(file);
            }
        }
    }
});

// Handle the change event for the file input
fileInput.addEventListener('change', function(e) {
    if (fileInput.files.length > 0) {
        updatePreview(fileInput.files[0]);
    }
});

// Handle the click event for the delete button
delete_image_Button.addEventListener('click', function(e) {
    e.preventDefault();

    clearPreview();
});
