<?php

require_once '../Library/sessionstart.php';
require_once 'functions.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    $password = trim($password);
    $nickname = trim($nickname);

    $user = getUser($nickname);
    if ($user) {
        $hashedPassword = $user['password'];
        $hashedPassword = trim($hashedPassword);
        echo "Entered Password: " . $password . "<br>";
        echo "Stored Hashed Password: " . $hashedPassword . "<br>";
        
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['usernickname'] = $user['nickname'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['country'] = $user['country'];
            $_SESSION['date'] = $user['date_created'];
            header("Location: /Testik/index.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid nickname.";
    }
}
?>