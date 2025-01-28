<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    require_once 'adminfunctions.php';
    $userexists = getuser($nickname);
    if ($userexists || getUserByEmail($email)){
        header('Location: users.php?failure=2');
        exit;
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        insertuser($nickname, $password, $email, $role);
        header('Location: users.php?success=1');
        exit;
    }
}

?>
