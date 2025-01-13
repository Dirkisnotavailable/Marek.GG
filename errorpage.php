<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/errorpagestyle.css">
    <title>ERROR!</title>
</head>
<body>
<?php
    require_once 'Player/designfunctions.php';
    renderNavbar(); ?>
    <div class="container">
        <div class="error-icon">
            <img src="CSS/erroricon.png" alt="Error Icon">
        </div>
        <h1>Sorry!</h1>
        <p class="error-message">
The page you are looking for might have been removed, had its name changed, or is temporarily unavailable. 
    Please check the URL for proper spelling and capitalization. If you're having trouble locating a destination on our site, try visiting the home page through this button</p>
        <a href="/Testik/index.php" class="button">Go to Main Page</a>
    </div>
</body>
</html>