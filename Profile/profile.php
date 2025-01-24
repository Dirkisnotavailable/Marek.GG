<?php 

require_once '../Library/sessionstart.php';

if(!isset($_SESSION['usernickname']))
{
    header("Location: /Testik/login/loginform.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marek.gg - Profile</title>
    <link rel="stylesheet" href="/Testik/Profile/Profile.css">
</head>
<body>
    <?php
    require_once '../CSS/designfunctions.php';
    renderNavbar();
    ?>
    <div class="container">
        <div class="containerleft">
            <img class= "profileimage" src="account.png" alt="Profile image">
        </div>
        <div class="containerright">
            <div class="profilenick">
                <?php echo "<p class='nickname'>" .  $_SESSION['usernickname'] . "</p>" ?>
            </div>
            <div class="role">
                <p class="role"><?php echo $_SESSION['role'] ?></p>
            </div>
            <div class="profileinfo">
                <p class="info">Email: <?php echo $_SESSION['email'] ?></p>
                <a href="#" class="changelink" id="changeemail">Change Email</a>
                <div id="emailForm">
                    <h2>Change your email</h2>
                    <form id="email-form">
                        <label for="new-email">Your new email:</label>
                        <input type="email" id="new-email" name="new-email" placeholder="marek@gmail.com" required>
                        <button type="submit">Submit</button>
                    </form>
                </div>
                <p class="info2">Country: <?php echo $_SESSION['country'] ?></p>
                <a href="#" class="changelink" id="changecountry">Change Country</a>
                <div class="countryform">
                    <h2>Change Country</h2>
                    <form id="country-form">
                        <label for="new-country">New Country:</label>
                        <select id="new-country" name="new-country" required>
                <option value="">Select your country</option>>
                <?php require '../Registration/countries.php';
                foreach ($countries as $code => $country) {
                    echo "<option value=\"$code\">$country</option>";
                }
                ?>
            </select>
                        <button type="submit" class="change-button">Submit</button>
                    </form>
                </div>
                <p class="info3">Created on: <?php echo date("d.m.Y H:i", strtotime($_SESSION['date'])) ?></p>
            </div>
            <div class="profile-button">
                <?php
                if ($_SESSION['role'] == 'admin') {
                    echo '<a href="/Testik/Admin/adminpanel.php" class="button">Admin Panel</a>';
                } else {
                    echo '<a href="/Testik/Profile/forgotpassword.php" class="button">Reset Password</a>';
                }
                ?>
            </div>
        </div>
    </div>
</body>
<footer>
    <?php
    renderFooter();
    ?>
</footer>
<script src="/Testik/Profile/profile.js"></script>
</html>