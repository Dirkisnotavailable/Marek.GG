<?php
require_once '../Library/sessionstart.php';
require_once '../Library/Database.php';

header('Content-Type: application/json');

$conn = (new Database())->getConnection();
//Prekladanie divneho JSON formatu na normalny PHP format
$data = json_decode(file_get_contents('php://input'), true);

$streamerId = $data['userId'];
$column = $data['column'];
$newValue = $data['newValue'];


$stmt = $conn->prepare("UPDATE streamer SET $column = ? WHERE streamerid = ?");
$result = $stmt->execute([$newValue, $streamerId]);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update streamer']);
}
?>
