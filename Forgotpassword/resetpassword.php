<?php
require_once 'functions.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $reset = checkCode($code);
    if (!$reset) {
        header("Location: /Testik/index.php");
    }
} else {
    header("Location: /Testik/index.php");
}

?>
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
    <script>
        function validateForm() {
            var password = document.getElementById("password").value;
            var passwordConfirm = document.getElementById("password_confirm").value;
            if (password !== passwordConfirm) {
                alert("Passwords do not match!");
                return false; 
            }
            return true;
        }
    </script>
</head>

<body>
    <?php
    require_once '../CSS/designfunctions.php';
    renderNavbar(); ?>

    <div id="form-container">
        <img id="form-image" src="jhin.gif" alt="Form Image">
        <form id="registrationform" action="processresetpassword.php" method="post" onsubmit="return validateForm()">
            <img id="login-image" src="account.png" alt="">
            <header id="formhead">Change password
            </header>
            <input type="hidden" name="code" value="<?php echo $code; ?>">
            <div class="form-row">
                <div class="form-group-names">
                    <input id="password" type="password" name="password" autocomplete="new-password" required placeholder="Password">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group-names">
                    <input id="password_confirm" type="password" name="password_confirm" required placeholder="Password confirm">
                </div>
            </div>
            <button id="submit-button" type="submit">Change password!</button>
        </form>
    </div>

</body>
<footer>
    <?php
    renderFooter();
    ?>

</html>