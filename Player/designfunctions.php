<?php
function renderNavbar() {
    echo '
    <nav>
        <a href="/Testik/index.php" class="logo">Marek.GG</a>
        <div class="right-links">
            <a href= "/Testik/Provods/provods.php">
                <i class="fi fi-rr-globe"></i>
                ProVods
            </a>
            <a href="">Signup</a>
            <a href="">Login</a>
        </div>
        <span></span>
    </nav>
    ';
}
function renderMatchHistoryfromDTB($alldata) {
    foreach($alldata as $data)
    {
      $kills = $data['kills'];
      $deaths = $data['deaths'];
      $assists = $data['assists'];
      $kdanum = $data['kills']. '/' . $data['deaths'] . '/' . $data['assists'];
      if ($data['deaths'] == 0){
        $kdanum = ($data['kills'] + $data['assists'] ) / 1;
      } else {
        $kdanum = ($data['kills'] + $data['assists'] ) / $data['deaths'];
      }
      $kdanum = round($kdanum, 2);
      $cs = $data['CS'];
      $champion = $data['champion'];
      $items = [
        $data['item1'],
        $data['item2'],
        $data['item3'],
        $data['item4'],
        $data['item5'],
        $data['item6'],
        $data['item7'],
      ];
      $summonerspells = [
        $data['summoner1'],
        $data['summoner2'],
      ];
      $primaryrune = $data['rune_primary'];
      $secondaryrune = $data['rune_secondary'];
      $win = $data['result'];
      $gametime = $data['match_time'];
  
      echo '
        <div class="match-container">
    <div class="match '.$win.'">
  
    <div class="content-wrapper">
      <div class="left-section">
            <img class="champ-icon" src="Datadragon/img/champion/'.$champion.'.png" alt="">
        <div class="summoner-spells">
  
          <img class="spell spell-1" src="Datadragon/img/summonerspell/'.$summonerspells[0].'.png" alt="">
          <img class="spell spell-2" src="Datadragon/img/summonerspell/'.$summonerspells[1].'.png" alt="">
        </div>
        <div class="runes">
          <img class="rune-main '.$win.'" src="Datadragon/img/runes/primary/'.$primaryrune.'.png" alt="">
          <img class="rune-secondary '.$win.'" src="Datadragon/img/runes/secondary/'.$secondaryrune.'.png" alt="">
        </div>
      </div>
      <div class="middle-section">
      <div class="kda">'. $kills . ' / ' . $deaths .' / ' . $assists . '</div>
        <div class="kda-calculation">' . $kdanum . ' (KDA)</div>
        <div class="cs-kp">CS: ' . $cs . '</div>
        <div class="items">
         <img class = "match-item" src="Datadragon/img/item/'.$items[0].'.png" alt="">
         <img class = "match-item" src="Datadragon/img/item/'.$items[1].'.png" alt="">
         <img class = "match-item" src="Datadragon/img/item/'.$items[2].'.png" alt="">
         <img class = "match-item" src="Datadragon/img/item/'.$items[3].'.png" alt="">
         <img class = "match-item" src="Datadragon/img/item/'.$items[4].'.png" alt="">
         <img class = "match-item" src="Datadragon/img/item/'.$items[5].'.png" alt="">
         <img class = "match-item" src="Datadragon/img/item/'.$items[6].'.png" alt="">
      </div>  
        </div>
      </div>
  </div>
    </div>
  
      ';    
    }
}

function renderMatchHistoryfromAPI($alldata) {
    foreach($alldata as $data)
  {
    $kills = $data['playerStats']['kills'];
    $deaths = $data['playerStats']['deaths'];
    $assists = $data['playerStats']['assists'];
    if ($data['playerStats']['deaths'] == 0){
      $kdanum = ($data['playerStats']['kills'] + $data['playerStats']['assists'] ) / 1;
    } else {
      $kdanum = ($data['playerStats']['kills'] + $data['playerStats']['assists'] ) / $data['playerStats']['deaths'];
    }
    $kdanum = round($kdanum, 2);
    $cs = $data['playerStats']['farm'];
    $champion = $data['playerStats']['champion'];
    $items = [
      $data['items'][0],
      $data['items'][1],
      $data['items'][2],
      $data['items'][3],
      $data['items'][4],
      $data['items'][5],
      $data['items'][6],
    ];
    $summonerspells = [
      $data['summonerSpells'][0],
      $data['summonerSpells'][1],
    ];
    $primaryrune = $data['runes']['mainRune'];
    $secondaryrune = $data['runes']['secondaryRune'];
    $win = $data['playerStats']['result'];
    $gametime = $data['matchTime'];

    echo '
      <div class="match-container">
  <div class="match '.$win.'">

  <div class="content-wrapper">
    <div class="left-section">
          <img class="champ-icon" src="Datadragon/img/champion/'.$champion.'.png" alt="">
      <div class="summoner-spells">

        <img class="spell spell-1" src="Datadragon/img/summonerspell/'.$summonerspells[0].'.png" alt="">
        <img class="spell spell-2" src="Datadragon/img/summonerspell/'.$summonerspells[1].'.png" alt="">
      </div>
      <div class="runes">
        <img class="rune-main '.$win.'" src="Datadragon/img/runes/primary/'.$primaryrune.'.png" alt="">
        <img class="rune-secondary '.$win.'" src="Datadragon/img/runes/secondary/'.$secondaryrune.'.png" alt="">
      </div>
    </div>
    <div class="middle-section">
    <div class="kda">'. $kills . '/' . $deaths . '/'. $assists . '</div>
      <div class="kda-calculation">' . $kdanum . ' KDA </div>
      <div class="cs-kp">CS/M: ' . $cs . '</div>
      <div class="items">
       <img class = "match-item" src="Datadragon/img/item/'.$items[0].'.png" alt="">
       <img class = "match-item" src="Datadragon/img/item/'.$items[1].'.png" alt="">
       <img class = "match-item" src="Datadragon/img/item/'.$items[2].'.png" alt="">
       <img class = "match-item" src="Datadragon/img/item/'.$items[3].'.png" alt="">
       <img class = "match-item" src="Datadragon/img/item/'.$items[4].'.png" alt="">
       <img class = "match-item" src="Datadragon/img/item/'.$items[5].'.png" alt="">
       <img class = "match-item" src="Datadragon/img/item/'.$items[6].'.png" alt="">
    </div>  
      </div>
    </div>
</div>
  </div>

    ';    
  }
}


?>