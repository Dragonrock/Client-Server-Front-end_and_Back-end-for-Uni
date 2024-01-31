<?php
include '../includes/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$employeeId = $data['id'];
$newJobTitle = $data['jobTitle'];

// Define the job title tables
$jobTitleTables = ['Cook', 'Cashier', 'DeliveryBoy'];

// Delete the employee from their current job title table
foreach ($jobTitleTables as $jobTitleTable) {
    $stmt = $conn->prepare("DELETE FROM $jobTitleTable WHERE employee_id = ?");
    $stmt->execute([$employeeId]);
}

// Insert the employee into the new job title table
$stmt = $conn->prepare("INSERT INTO $newJobTitle (employee_id) VALUES (?)");
$stmt->execute([$employeeId]);

if ($stmt->rowCount() > 0) {
    echo 'Job title updated successfully';
} else {
    echo 'Could not update job title';
}

header('Location: manager-dashboard.php');
?>