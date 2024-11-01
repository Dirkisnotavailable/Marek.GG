<?php
session_start();
$profileicon = isset($_SESSION['iconid']) ?$_SESSION['iconid'] : 'nothing';
$nickname = isset($_SESSION['nickname']) ? $_SESSION['nickname'] : 'NO PLAYER';
$level = isset($_SESSION['level']) ? $_SESSION['level'] : '0';
$wins_solo = isset($_SESSION['wins_solo']) ? $_SESSION['wins_solo'] : 0;
$losses_solo = isset($_SESSION['losses_solo']) ? $_SESSION['losses_solo'] : 0;
$tier_solo = isset($_SESSION['tier_solo']) ? $_SESSION['tier_solo'] : 'Unranked';
$rank_solo = isset($_SESSION['rank_solo']) ? $_SESSION['rank_solo'] : '';
$lp_solo = isset($_SESSION['lp_solo']) ? $_SESSION['lp_solo'] : 0;

$wins_flex = isset($_SESSION['wins_flex']) ? $_SESSION['wins_flex'] : 0;
$losses_flex = isset($_SESSION['losses_flex']) ? $_SESSION['losses_flex'] : 0;
$tier_flex = isset($_SESSION['tier_flex']) ? $_SESSION['tier_flex'] : 'Unranked';
$rank_flex = isset($_SESSION['rank_flex']) ? $_SESSION['rank_flex'] : '';
$lp_flex = isset($_SESSION['lp_flex']) ? $_SESSION['lp_flex'] : 0;

if ($losses_flex != 0)
{
  $winrate_flex = ($wins_flex/($wins_flex+$losses_flex) * 100);
  $winrate_flex = round($winrate_flex);
}
if ($losses_solo != 0)
{
  $winrate_solo = ($wins_solo/($wins_solo+$losses_solo) * 100);
  $winrate_solo = round($winrate_solo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Stats</title>
    <link rel="stylesheet" href="CSS/style.css?ref=v1"> 
</head>
<body>
  <div class="Head">
    <div class="item item-0">
    <?php
        $img_url = "Datadragon/img/profileicon/".($profileicon).".png";
        ?>
              <img src="<?php echo  $img_url; ?>" alt="" class="profile_icon">
      <h3><?php echo("$nickname"); ?></h3>
      <h4>Level: <?php echo("$level") ?></h4>
    </div>

  </div>
<div class="container">
  <div class="item item-1">Champy, staty a tak</div>
      <div class="item item-2">
          <div class="ranked-data">
            <h2>Ranked Solo/Duo</h2>
            <?php 
              if (isset($winrate_solo)){
               $img_url = "Datadragon/Ranked/".($tier_solo).".png";
              } else {
               $img_url = "Datadragon/Ranked/Unranked.png";
              }
             ?>
            <img src="<?php echo  $img_url; ?>" alt="" class="rank_icon">
            <div class="stat">
              <span class="rank_solo"><?php echo htmlspecialchars("$tier_solo $rank_solo ($lp_solo LP)"); ?></span>
                <div id="rank_image"></div>
            </div>
            <div class="stat">
              <span class="wins">Wins:</span>
              <span class="wins_value"><?php echo htmlspecialchars($wins_solo); ?></span>
            </div>
            <div class="stat">  
              <span class="losses">Losses:</span>
              <span class="losses_value"><?php echo htmlspecialchars($losses_solo); ?></span>
            </div>
            <div class="stat">
            <span class="winrate"><?php if(isset($winrate_solo)){
               echo ("$winrate_solo%");} else {
                echo ("0%");
               } 
               
               ?></span>
               </div>
          </div>
        </div>
        <div class="item item-2">
          <div class="ranked-data">
            <h2>Ranked Flex</h2>
            <?php 
            if (isset($winrate_flex)){
              $img_url = "Datadragon/Ranked/".($tier_flex).".png";
            } else {
              $img_url = "Datadragon/Ranked/Unranked.png";
            }
            ?>
            <img src="<?php echo  $img_url; ?>" alt="" class="rank_icon">
            <div class="stat">
              <span class="rank_flex"><?php echo htmlspecialchars("$tier_flex $rank_flex ($lp_flex LP)"); ?></span>
                <div id="rank_image"></div>
            </div>
            <div class="stat">
              <span class="wins">Wins:</span>
              <span class="wins_value"><?php echo htmlspecialchars($wins_flex); ?></span>
            </div>
            <div class="stat">
              <span class="losses">Losses:</span>
              <span class="losses_value"><?php echo htmlspecialchars($losses_flex); ?></span>
            </div>
            <div class="stat">
            <span class="winrate"><?php if(isset($winrate_flex)){
              echo ("$winrate_flex%");} 
               else {
                echo ("0%");
               } 
               
               ?></span>
               </div>
          </div>
    </div>
</div>
<div class="container">
<div class="item item-4">Champy, staty a tak</div>
</div>
</body>
</html>


