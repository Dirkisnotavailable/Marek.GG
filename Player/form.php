<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rise.gg - Search Player</title>
    <link rel="stylesheet" href="Player/CSS/searchpage.css"> 
</head>

<body>
    <?php
    require_once 'designfunctions.php';
   renderNavbar(); ?>
    <div class="container">
        <div class="right-section">
            <h1>Search for a Player!</h1>
            <form id="formular" action="" method="post">
                <div class="form-group">
                    <label for="name"></label>
                    <input id="name" type="text" name="playername" required placeholder="Username" pattern=".*#.*">
                </div>
                
                <div class="form-group">
                    <label for="choose_region"></label>
                    <select name="region" id="choose_region" required aria-placeholder="Region">
                        <option value="0">EUNE</option>
                        <option value="1">EUW</option>
                        <option value="2">JP</option>
                        <option value="3">NA</option>
                        <option value="4">KR</option>
                    </select>
                </div>

                <input type="submit" value="Search!" class="original-button">
            </form>
        </div>
    </div>
</body>
</html>



<?php

?>


