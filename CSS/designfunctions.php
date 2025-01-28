<?php

function renderNavbar() {
    echo '
        <link rel="stylesheet" href="/Testik/CSS/navbar.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <nav>
        <div class="left-links">
            <a href="/Testik/index.php" class="logo">Marek.GG</a>
        </div>
        <div class="center-links">
            <a href="/Testik/index.php">
                <i class="fas fa-search"></i> 
                Search a Player
            </a>
            <a href="/Testik/Provods/provods.php">
                <i class="fas fa-video"></i> 
                ProVods
            </a>
        </div>
        <div class="right-links">';
    if (isset($_SESSION['usernickname'])) {
        echo '
        <div class="dropdown">
            <button class="dropbtn">
                <i class="fas fa-user"></i> '. $_SESSION['usernickname'] .'
            </button>
            <div class="dropdown-content">
                <a href="/Testik/Profile/profile.php">Profile</a>';
        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
            echo '<a href="/Testik/Adminpanel/dashboard.php">Admin Panel</a>';
        }
        echo '<a href="/Testik/Logout/logout.php">Logout</a>
            </div>
        </div>';
    } else {
        echo '<a href="/Testik/Registration/registerform.php">
                  <i class="fas fa-user-plus"></i>
                  Signup
              </a>
              <a href="/Testik/Login/loginform.php">
                  <i class="fas fa-sign-in-alt"></i> 
                  Login
              </a>';
    }
    echo '
        </div>
    </nav>
    ';
}
function rendersidebar() {
  echo '
  <link rel="stylesheet" href="/Testik/CSS/sidebar.css">
  <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="/Testik/adminpanel/dashboard.php">Dashboard</a></li>
                <li><a href="/Testik/adminpanel/users.php">Users</a></li>
                <li><a href="/Testik/adminpanel/streamers.php">Streamers</a></li>
                <li><a href="/Testik/adminpanel/settings.php">Settings</a></li>
            </ul>
        </div>';
}

function renderFooter() {
    echo '
        <link rel="stylesheet" href="/Testik/CSS/footer.css">
    <footer>
        <div class="footer-content">
            <div class="footer-center about">
                <h2 class="logo-text">Marek.GG</h2>
                <p>
                    Marek.GG is a platform dedicated to providing the best gaming content and community for gamers around the world.
                </p>
                <div class="contact">
                    <span><i class="fas fa-phone"></i> &nbsp; +421907182598</span>
                    <span><i class="fas fa-envelope"></i> &nbsp; info@marek.gg</span>
                </div>
                <div class="socials">
                    <a href="https://facebook.com" target="_blank"><img src="/Testik/Player/CSS/icons/facebook.png" class="socialimg"></a>
                    <a href="https://x.com" target="_blank"><img src="/Testik/Player/CSS/icons/twitter.svg" class="socialimg"></a>
                    <a href="https://instagram.com" target="_blank"><img src="/Testik/Player/CSS/icons/instagram.png" class="socialimg"></a>
                </div>
            </div>
            <div class="footer-center-links">
                <h2 class="link-label">Quick Links</h2>
                <ul class="quick-links">
                    <a href="/Testik/Events"><li>Events</li></a>
                    <a href="/Testik/Team"><li>Team</li></a>
                    <a href="/Testik/Mentors"><li>Mentors</li></a>
                    <a href="/Testik/Gallery"><li>Gallery</li></a>
                    <a href="/Testik/Other/TermsandConditions.php"><li>Terms and Conditions</li></a>
                </ul>
            </div>
            <div class="footer-center contact-form">
                <h2>Contact us</h2>
                <br>
                <form action="/Testik/Other/footerprocess_form.php" method="post">
                    <input type="email" name="email" required class="text-input contact-input" placeholder="Your email address...">
                    <textarea name="message" required class="text-input contact-input" placeholder="Your message..."></textarea>
                    <button type="submit" class="btn btn-big">
                        <i class="fas fa-envelope"></i>
                        Send
                    </button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            ' . date("Y") . ' &copy; marek.gg | Designed by Denis Hronec
        </div>
    </footer>
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
?>