<?php
require_once '../Library/sessionstart.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['nickname'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    require_once 'functions.php';

    if (getUserByEmail($email)) {
        $_SESSION['error'] = "An account with this email already exists. Please use a different email.";
        header("Location: /Testik/Registration/registerform.php");
        exit();
    }

    if (strlen($password) < 8) {
        $_SESSION['error'] = "Password must be at least 8 characters long!";
        header("Location: /Testik/Registration/registerform.php");
        exit();
    }

    if (getuser($username)) {
        $_SESSION['error'] = "An account with this username already exists. Please choose a different username.";
        header("Location: /Testik/Registration/registerform.php");
        exit();
    }

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
        header("Location: /Testik/index.php?success=1");
        exit();
    }
}
?>
