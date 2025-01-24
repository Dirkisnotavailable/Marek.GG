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
    require_once './Library/sessionstart.php';
    require_once 'CSS/designfunctions.php';
    renderNavbar(); ?>
    <div class="container">
    <img src="Player/CSS/logolol2.png" class="image">
        <img src="Player/CSS/frontimage.png" class="frontimage">
        <div class="searchmenu">
            <form id="formular" action="" method="post">
                <div class="form-group-inline">
                    <label for="name"></label>
                    <input id="name" type="text" name="playername" required placeholder="Username" pattern=".*#.*">
                    <label for="choose_region"></label>
                    <select name="region" id="choose_region" required aria-placeholder="Region">
                        <option value="0">EUNE</option>
                        <option value="1">EUW</option>
                        <option value="2">JP</option>
                        <option value="3">NA</option>
                        <option value="4">KR</option>
                    </select>
                    <input type="submit" value="Search!" class="original-button">
                </div>
            </form>
        </div>
        <img src="Player/CSS/fronttitle.png" class="fronttitle">
    </div>
    <?php renderFooter(); ?>
</body>
</html>