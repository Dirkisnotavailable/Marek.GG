<?php
require_once '../Library/sessionstart.php';
require_once "../Library/Database.php";
$conn = (new Database())->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newcountry = $_POST['new-country'];
    $email = $_SESSION['email'];
    try {
        $stmt = $conn->prepare("UPDATE users SET country = ? WHERE email = ?");
        $stmt->execute([$newcountry, $email]);
        $_SESSION['country'] = $newcountry;
        echo "<p>Country updated successfully.</p>";
    } catch(Exception $e){
        $error = $e->getMessage();
        echo "<p>Chyba:$error</p>";
    }
}
?>
