<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marek.GG - Registration</title>
    <link rel="stylesheet" href="forgotpassword.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <?php 
    require_once '../Library/sessionstart.php';
    require_once '../CSS/designfunctions.php';
    renderNavbar(); ?>

<div id="form-container">
    <img id="form-image" src="jhin.gif" alt="Form Image"> 
        <form id="registrationform" action="forgotpassword.php" method="post">
        <img id="login-image"src="account.png" alt="">
        <header id="formhead">Forgot password
        </header>
        <div class="form-row">
            <div class="form-group-names">
                <input id="email" type="email" name="email" required placeholder="Email"></div>
        </div>
        <button id="submit-button" type="submit">Reset password!</button>
    </form>
</div>

</body>
<footer>
    <?php
    renderFooter();
    ?>
</html>