<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['nickname'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    require_once 'functions.php';
    $hash= password_hash($password, PASSWORD_DEFAULT);
    adduser($username, $hash, $email, $country);
}
?>
