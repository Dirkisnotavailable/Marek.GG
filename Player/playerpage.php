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
$puuid = isset($_SESSION['puuid']) ? $_SESSION['puuid'] : 0;

// Zobrazuje ikonku a hodnoty ak hrac hral SoloQ alebo FlexQ
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

include('../CSS/designfunctions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marek.gg - <?php echo $nickname?>'s Stats</title>
    <link rel="stylesheet" href="CSS/playerpagestyle.css?v=20210819">
</head>
<body>
<?php renderNavbar(); ?>
    <div class="Head">
    <div class="item item-0">
      <div class="icon-level">
    <?php
        $img_url = "Datadragon/img/profileicon/".($profileicon).".png";
        ?>
              <img src="<?php echo  $img_url; ?>" alt="" class="profile_icon">
              <h4 class="level">Level: <?php echo("$level") ?></h4>
              </div>
      <h3><?php echo("$nickname"); ?></h3>
    </div>

  </div>
<div class="container">
  <div class="item item-1">
    <?php
      require_once 'matchhistory.php';
      require_once 'functions.php';

$championwin = getchampionWinrate($nickname);
$championgames = getChampiongames($nickname); 

$championWinrates = [];

if (empty($championwin) || empty($championgames)) {
  echo '<p class="error">Restart the page or search yourself once again to get a rundown about your most played champions and winrates with them.</p>';
} else {


foreach ($championgames as $game) {
  $championName = $game['champion'];
  $totalGames = $game['game_count'];

  $wins = 0;
  foreach ($championwin as $win) {
      if ($win['champion'] === $championName) {
          $wins = $win['game_count'];
          break;
      }
  }
  $winrate = ($totalGames > 0) ? ($wins / $totalGames) * 100 : 0;

  $championWinrates[] = [
      'champion' => $championName,
      'winrate' => $winrate,
      'games' => $totalGames,
      'wins' => $wins
  ];
}
usort($championWinrates, function($a, $b) {
  return $b['games'] - $a['games'];
});

$champcounter = 1;
foreach ($championWinrates as $champion) {
    if ($champion['games'] > 0 && $champcounter <= 8) {
        echo '
        <div class="champion-stats">
            <img class="winrate-icon" src="Datadragon/img/champion/' . $champion['champion'] . '.png" alt="">
            <div class= "champion-texts">
            <p class="winrate-text">' . number_format($champion['winrate'], 2) . '%</p>
            <p class="games-text">' . $champion['wins'] . ' / ' . $champion['games'] . ' games</p>
            </div>
        </div>
        ';
        $champcounter++;
    }
}

}

?>
</div>
      <div class="item item-2">
          <div class="ranked-data">
            <h2>Ranked Solo/Duo</h2>
            <?php 
              if (isset($winrate_solo)){
               $img_url = "Datadragon/Ranked/".($tier_solo)."_converted.webp";
              } else {
               $img_url = "Datadragon/Ranked/Unranked_converted.webp";
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
              $img_url = "Datadragon/Ranked/".($tier_flex)."_converted.webp";
            } else {
              $img_url = "Datadragon/Ranked/Unranked_converted.webp";
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
  <?php
  $alldata = getMatchhistory($nickname, $puuid, $level, $profileicon);
  /*echo "<pre>";
  var_dump($alldata);
  echo "</pre>"; */
  
  if (!empty($alldata) && isset($alldata[0]['player_id']))
  { //AK JE Z DATABAZE FETCHNUTE
    renderMatchHistoryfromDTB($alldata);
  } else {
    renderMatchHistoryfromAPI($alldata);
  }
  ?>
</body>
</html>



