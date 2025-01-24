<?php
require_once '../Library/sessionstart.php';
require_once "../Library/Database.php";
$conn = (new Database())->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newemail = $_POST['new-email'];
    $email = $_SESSION['email'];
    try {
    $stmt =  $conn->prepare("UPDATE users SET email = ? WHERE email = ?");
    $stmt->execute([$newemail, $email]);
    $_SESSION['email'] = $newemail;  
} catch(Exception $e){
    echo "<p>Chyba: {$e->getMessage()}</p>";
    }
}


?>