<?php
require_once '../Library/sessionstart.php';
require_once '../Library/database.php';
$conn = (new Database())->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO footer_contact (email, message) VALUES (?, ?);");

    $stmt->execute([$email, $message]);
    header("Location: /Testik/index.php?success=5");
    exit;
}




?>