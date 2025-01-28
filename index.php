<?php 
require_once './Library/sessionstart.php';

if (isset($_GET['success']))
{
    switch ($_GET['success']) {
        case 1:
            echo ' <script> alert("Registration successful! Please check your email for confirmation.") </script>';
            break;
        case 2:
            echo ' <script> alert("You have successfully logged in!") </script>';
            break;
        case 3:
            echo ' <script> alert("Password has been successfully reset!") </script>';
            break;
        case 4:
            echo ' <script> alert("An email to reset your password was send to your email!") </script>';
            break;
        case 5:
            echo ' <script> alert("Message sent! Thank you for your feedback!") </script>';
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marek.GG - Home</title>
    <link rel="stylesheet" href="CSS/searchpage.css">
</head>
<body>

<?php

    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    require 'Player/form.php';
    else if ($_SERVER['REQUEST_METHOD'] == 'POST')
    require 'Player/searchprocess.php';
?>
    
</body>
</html>