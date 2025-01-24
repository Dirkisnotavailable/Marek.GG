<?php
require_once 'functions.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $user = getUser($email);
    if ($user) {
        $nickname = $user['nickname'];
        $userid = $user['id'];
        $randomcode = bin2hex(random_bytes(12));
        $actionlink = "https://localhost/Testik/Forgotpassword/resetpassword.php?code=$randomcode";
        createPasswordReset($userid, $randomcode);
        $OS = $_SERVER['HTTP_USER_AGENT'];
        $template = file_get_contents('forgotpassword.html');
        $body = str_replace(["{{name}}", "{{operating_system}}", "{{action_url}}"], [$nickname, $OS, $actionlink], $template);
        sendemail($nickname, $email, $body);
        header("Location: /Testik/index.php");
    }
}




// https: //marek.gg/Profile/resetpassword.php?code=dasdkasldljkasd
