<?php
include '../includes/db.php';
session_start(); // Start the session if it's not already started

$firstname = $_POST['first_name'];
$lastname = $_POST['last_name'];
$salary = $_POST['salary'];
$social_security = $_POST['social_security'];
$jobtitle = $_POST['job_title'];
$FK1_id = $_SESSION['restaurant_id'];
// Get the current restaurant's id from the session

$stmt = $conn->prepare("SELECT employee_id FROM EMPLOYEES");
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

$employee_id = 1;
foreach ($sorted_ids as $db_id) {
    if ($employee_id != $db_id) break;
    $employee_id++;
}

$stmt = $conn->prepare("INSERT INTO EMPLOYEES (firstName, lastName, salary, social_security, employee_id, FK1_id) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([$firstname, $lastname, $salary, $social_security, $employee_id, $FK1_id]);

switch ($jobtitle) {
    case 'Cashier':
        $stmt = $conn->prepare("INSERT INTO Cashier (employee_id) VALUES (?)");
        $stmt->execute([$employee_id]);
        break;
    case 'Deliveryboy':
        $stmt = $conn->prepare("INSERT INTO DeliveryBoy (employee_id) VALUES (?)");
        $stmt->execute([$employee_id]);
        break;
    case 'Cook':
        $stmt = $conn->prepare("INSERT INTO Cook (employee_id) VALUES (?)");
        $stmt->execute([$employee_id]);
        break;
}

header('Location: manager-dashboard.php');

?>