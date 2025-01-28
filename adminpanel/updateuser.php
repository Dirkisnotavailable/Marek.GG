<?php
require_once '../Library/sessionstart.php';
require_once '../Library/Database.php';

header('Content-Type: application/json');

$conn = (new Database())->getConnection();
$data = json_decode(file_get_contents('php://input'), true);

$userId = $data['userId'];
$column = $data['column'];
$newValue = $data['newValue'];

$allowedColumns = ['id', 'nickname', 'email', 'country', 'role', 'date_created'];
if (!in_array($column, $allowedColumns)) {
    echo json_encode(['success' => false, 'message' => 'Invalid column']);
    exit();
}

$stmt = $conn->prepare("UPDATE users SET $column = ? WHERE id = ?");
$stmt->execute([$newValue, $userId]);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update user']);
}
?>
