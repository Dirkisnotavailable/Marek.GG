<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marek.GG - Registration</title>
    <link rel="stylesheet" href="registerform.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <?php 
    require_once '../Library/sessionstart.php';
    if (isset($_SESSION['usernickname']))
    {
        header("Location: /Testik/Profile/profile.php");
        exit();
    }
    require_once '../CSS/designfunctions.php';
    renderNavbar(); ?>

<div id="form-container">
    <header id="formhead">Create an account!</header>
    <img id="form-image" src="kaisa.gif" alt="Form Image">
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <script>
            alert("Registration successful! Please check your email for confirmation.");
        </script>
    <?php endif; ?>
    <form id="registrationform" action="regprocessform.php" method="post">
        <div class="form-row">
            <div class="form-group-names">
                <input id="nickname" type="text" name="nickname" required placeholder="Nickname">            </div>
        </div>
        <div class="form-row">
                <input id="email" type="email" name="email" required placeholder="Email">
        </div>
        <div class="form-row">
                <input id="password" type="password" name="password" required placeholder="Password" autocomplete="new-password">
        </div>
        <div class="form-row">
        <select id="country" name="country" required>
        <option value="">Select your country</option>
            <?php require_once 'countries.php';
            foreach ($countries as $code => $country) {
                echo "<option value=\"$code\">$country</option>";
            }
            ?>
        </select>
        </div>
        <div class="form-row-TOS">
            <input id="TOS" type="checkbox" name="TOS" required>
            <p class = "TOS-text">I agree to the <a href="/Testik/Other/TermsAndConditions.php">Terms of Service</a></p>
        </div>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <div class="form-row">
            <button id="submit-button" type="submit">Register</button>
        </div>
        <p id="login">Already have an account? <a href="/Testik/Login/loginform.php">Login!</a></p>
    </form>
</div>

</body>
<footer>
    <?php
    renderFooter();
    ?>
</html>