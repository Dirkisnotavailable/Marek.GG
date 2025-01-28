<?php

require_once '../Library/sessionstart.php';

if(isset($_SESSION['usernickname']))
{
    header("Location: /Testik/Profile/profile.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marek.GG - Registration</title>
    <link rel="stylesheet" href="loginform.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <?php 
    require_once '../CSS/designfunctions.php';
    renderNavbar(); ?>

<div id="form-container">
    <img id="form-image" src="jhin.gif" alt="Form Image"> 
        <form id="registrationform" action="loginprocessform.php" method="post">
        <img id="login-image"src="account.png" alt="">
        <header id="formhead">User Login
        </header>
        <div class="form-row">
            <div class="form-group-names">
                <input id="nickname" type="text" name="nickname" required placeholder="Nickname">            </div>
        </div>
        <div class="form-row">
                <input id="password" type="password" name="password" required placeholder="Password" autocomplete="new-password">     
        </div>
            <p class="forgotpassword"><a href="/Testik/Forgotpassword/forgotpasswordform.php">Forgot password?</a></p>
            <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
            <button id="submit-button" type="submit">Login</button>
            <p class="login">Don't have an account? <a href="/Testik/Registration/registerform.php">Register!</a></p>
        </div>
    </form>
</div>

</body>
<footer>
    <?php
    renderFooter();
    ?>
</html>