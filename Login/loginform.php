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
    <img id="form-image" src="jhin.gif" alt="Form Image"> <!-- Add your image path here -->
        <form id="registrationform" action="regprocessform.php" method="post">
        <img id="login-image"src="account.png" alt="">
        <header id="formhead">User Login
        </header>
        <div class="form-row">
            <div class="form-group-names">
                <input id="nickname" type="text" name="nickname" required placeholder="Nickname">            </div>
        </div>
        <div class="form-row">
                <input id="password" type="password" name="password" required placeholder="Password">
        </div>
            <button id="submit-button" type="submit">Register</button>
            <p id="login">Don't have an account? <a href="/Testik/Registration/registerform.php">Register!</a></p>

        </div>
    </form>
</div>

</body>
<footer>
    <?php
    renderFooter();
    ?>
</html>