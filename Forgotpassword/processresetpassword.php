<?php
require_once 'functions.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $code = $_POST['code'];
    $password_reset = checkcode($code);

    $user = getuserbyid($password_reset['user_id']);

    if($user) {
        $password = $_POST['password'];
        $password_confirm = $_POST['password_confirm'];

        if($password == $password_confirm) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?;");
            $stmt->execute([$hashed_password, $user['id']]);
            deleteCode($code);
            header("Location: /Testik/index.php");
        } else {
            echo "Passwords do not match!";
        }

    } else {
        echo "User not found!";
    }
}