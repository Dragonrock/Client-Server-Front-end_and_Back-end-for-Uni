<?php
include '../includes/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$employeeId = $data['id'];

$stmt = $conn->prepare("DELETE FROM EMPLOYEES WHERE employee_id = ?");
$stmt->execute([$employeeId]);

if ($stmt->rowCount() > 0) {
    echo 'Employee fired successfully';
} else {
    echo 'Could not fire employee';
}

// Depending on the job title of the employee, you also need to delete the record from the corresponding table
$stmt = $conn->prepare("DELETE FROM Cashier WHERE employee_id = ?");
$stmt->execute([$employeeId]);

$stmt = $conn->prepare("DELETE FROM DeliveryBoy WHERE employee_id = ?");
$stmt->execute([$employeeId]);

$stmt = $conn->prepare("DELETE FROM Cook WHERE employee_id = ?");
$stmt->execute([$employeeId]);

header('Location: manager-dashboard.php');
?>