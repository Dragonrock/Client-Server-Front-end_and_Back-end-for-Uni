<?php
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


include '../includes/db.php';

$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];
$isactive = isset($_POST['isactive']) ? 1 : 0;
$newType = $_POST['type'];

// Update the restaurant table
$stmt = $conn->prepare("UPDATE restaurant SET name = ?, description = ?, isactive = ? WHERE id = ?");
$stmt->execute([$name, $description, $isactive, $id]);


if (isset($_FILES['image'])) {
    $uploadDir = '../r_images/';
    $newFileName = $id . '.png'; // Always save the image with the .png extension
    $uploadFile = $uploadDir . $newFileName;

}
// Delete from the current type table
$currentType = getCurrentType($id);
$stmt = $conn->prepare("DELETE FROM " . strtoupper($currentType) . " WHERE id = ?");
$stmt->execute([$id]);

// Insert into the new type table
$stmt = $conn->prepare("INSERT INTO " . strtoupper($newType) . " (id) VALUES (?)");
$stmt->execute([$id]);



header('Location: owner-dashboard.php');
?>