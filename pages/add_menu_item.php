<?php
session_start(); // Start the session

include '../includes/db.php';

$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$cook_id = $_POST['cook'];
$restaurant_id = $_SESSION['restaurant_id'];

$stmt = $conn->prepare("SELECT menu_item_id FROM menu_item"); 
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

$stmt = $conn->prepare("INSERT INTO menu_item (menu_item_id, name, description, price, fk1_menu_id) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$id, $name, $description, $price, $restaurant_id]);

$stmt = $conn->prepare("INSERT INTO COOKS (FK1_employee_id, FK2_menu_item_id) VALUES (?, ?)");
$stmt->execute([$cook_id, $id]);
header('Location: manager-dashboard.php');
?>