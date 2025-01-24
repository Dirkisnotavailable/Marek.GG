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
    require_once './Library/sessionstart.php';

    if ($_SERVER['REQUEST_METHOD'] == 'GET')
    require 'Player/form.php';
    else if ($_SERVER['REQUEST_METHOD'] == 'POST')
    require 'Player/searchprocess.php';
?>
    
</body>
</html>