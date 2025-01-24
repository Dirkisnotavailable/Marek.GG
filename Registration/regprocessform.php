<?php
require_once '../Library/sessionstart.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['nickname'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    require_once 'functions.php';
    $hash = password_hash($password, PASSWORD_DEFAULT);
    adduser($username, $hash, $email, $country);

    $user = getUser($username);
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['usernickname'] = $user['nickname'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['country'] = $user['country'];
        $_SESSION['date'] = $user['date_created'];
        $template = file_get_contents('emailpage.html');
        $body = str_replace("{{username}}", $username, $template);
        sendemail($username, $email, $body);
        header("Location: /Testik/index.php");
        exit();
    }
}
?>
