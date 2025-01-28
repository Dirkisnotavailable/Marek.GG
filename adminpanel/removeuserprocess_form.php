<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = $_POST['nickname'];
    require_once 'adminfunctions.php';

    if (!getUser($nickname)) {
        header('Location: users.php?failure=1');
        exit;
    } else {
        removeUser($nickname);
        header('Location: users.php?success=2');
        exit;
    }
}
?>
