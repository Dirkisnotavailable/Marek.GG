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
        
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['usernickname'] = $user['nickname'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['country'] = $user['country'];
            $_SESSION['date'] = $user['date_created'];
            header("Location: /Testik/index.php?success=2");
            exit();
        } else {
            $_SESSION['error'] = "Invalid password.";
            header("Location: /Testik/Login/loginform.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "User not found.";
        header("Location: /Testik/Login/loginform.php");
        exit();
    }
}
?>