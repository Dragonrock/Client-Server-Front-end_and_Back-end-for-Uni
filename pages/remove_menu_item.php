<?php
include '../includes/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$menuItemId = $data['menu_item_id'];

$stmt = $conn->prepare("DELETE FROM MENU_ITEM WHERE menu_item_id = ?");
$stmt->execute([$menuItemId]);

$stmt2 = $conn->prepare("DELETE FROM COOKS WHERE fk2_menu_item_id = ?");
$stmt2->execute([$menuItemId]);

if ($stmt->rowCount() > 0) {
    echo 'Menu item removed successfully';
} else {
    echo 'Could not remove menu item';
}
?>