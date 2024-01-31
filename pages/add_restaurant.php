<?php
include '../includes/db.php';

$name = $_POST['name'];
$description = $_POST['description'];
$isactive = isset($_POST['isactive']) ? 1 : 0;
$type = $_POST['type'];

$stmt = $conn->prepare("SELECT id FROM restaurant");
$stmt->execute();
$ids = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

function quicksort($array)
{
    if(count($array) < 2){
        return $array;
    }
    $left = $right = array();
    reset($array);
    $pivot_key = key($array);
    $pivot = array_shift($array);
    foreach($array as $k => $v){
        if($v < $pivot)
            $left[$k] = $v;
        else
            $right[$k] = $v;
    }
    return array_merge(quicksort($left), array($pivot_key => $pivot), quicksort($right));
}

$sorted_ids = quicksort($ids);

$id = 1;
foreach ($sorted_ids as $db_id) {
    if ($id != $db_id) break;
    $id++;
}

$stmt = $conn->prepare("SELECT menu_id FROM menu");
$stmt->execute();
$menu_ids = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$sorted_menu_ids = quicksort($menu_ids);

$FK1_menu_id = 1;
foreach ($sorted_menu_ids as $menu_db_id) {
    if ($FK1_menu_id != $menu_db_id) break;
    $FK1_menu_id++;
}

$menu_name = "first_menu_" . $name; // Set the name for the menu

// Insert into the menu table first
$stmt = $conn->prepare("INSERT INTO menu (menu_id, name) VALUES (?, ?)");
$stmt->execute([$FK1_menu_id, $menu_name]);

// Then insert into the restaurant table
$stmt = $conn->prepare("INSERT INTO restaurant (name, description, isactive, id, FK1_menu_id) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$name, $description, $isactive, $id, $FK1_menu_id]);

// Insert into the correct type table
switch ($type) {
    case 'sushi':
        $stmt = $conn->prepare("INSERT INTO SUSHI (id) VALUES (?)");
        break;
    case 'chinese':
        $stmt = $conn->prepare("INSERT INTO CHINESE (id) VALUES (?)");
        break;
    case 'italian':
        $stmt = $conn->prepare("INSERT INTO ITALIAN (id) VALUES (?)");
        break;
    case 'vegan':
        $stmt = $conn->prepare("INSERT INTO VEGAN (id) VALUES (?)");
        break;
    case 'mexican':
        $stmt = $conn->prepare("INSERT INTO MEXICAN (id) VALUES (?)");
        break;
}
$stmt->execute([$id]);



if (isset($_FILES['image'])) {
    $uploadDir = '../r_images/';
    $newFileName = $id . '.png'; // Always save the image with the .png extension
    $uploadFile = $uploadDir . $newFileName;


    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
        echo 'File is valid, and was successfully uploaded.';
    } else {
        echo 'Possible file upload attack!';
    }
}
header('Location: owner-dashboard.php');
?>