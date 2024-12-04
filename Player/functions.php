<?php 
$dbhost = "localhost";
$dbname="riseplayerdata";
$User="riseadmin";
$password="";

try{
    $conn = new PDO("mysql:host={$dbhost};dbname={$dbname};charset=utf8mb4", $User, $password);
} catch(Exception $e){
    $error = $e->getMessage();
    echo "<p>Chyba:$error</p>";
}

function insertdata($player_nick, $level, $icon){
    global $conn;
    try {
        $stmt = $conn->prepare("
        INSERT INTO player (id, nickname, level, icon, last_updated)
        VALUES (null, ?, ?, ?, NOW())
        ON DUPLICATE KEY UPDATE 
            level = VALUES(level), 
            icon = VALUES(icon), 
            last_updated = VALUES(last_updated)
    ");
    $stmt->execute([$player_nick, $level, $icon]);
    }catch(Exception $e){
        echo "<p>Chyba: {$e->getMessage()}</p>";
    }
}

function insertmatchdata($player_nick, $data)
{
    global $conn;

    foreach ($data as $match) {

        $player_stats = $match['playerStats'];
        $items = $match['items'];
        $match_time = $match['matchTime'];
        $summoner_spells = $match['summonerSpells'];
        $runes = $match['runes'];
        $blue_team = $match['blueTeam'];
        $red_team = $match['redTeam'];
        $stmt = $conn->prepare("
            INSERT INTO player_matches 
            (match_id, player_id, champion, summoner1, summoner2, rune_primary, rune_secondary, 
            kills, deaths, assists, CS, item1, item2, item3, item4, item5, item6, item7, match_time)
            VALUES 
            (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->execute([
                $player_nick,
                $player_stats['champion'],                   // champion
                $summoner_spells[0],                         // summoner1
                $summoner_spells[1],                         // summoner2
                $runes['mainRune'],                          // rune_primary
                $runes['secondaryRune'],                     // rune_secondary
                $player_stats['kills'],                      // kills
                $player_stats['deaths'],                     // deaths
                $player_stats['assists'],                    // assists
                $player_stats['farm'],                       // CS (Creep Score)
                $items[0],                                   // item1
                $items[1],                                   // item2
                $items[2],                                   // item3
                $items[3],                                   // item4
                $items[4],                                   // item5
                $items[5],                                   // item6
                $items[6],
                $match_time,                                 // match_time (formatted as "i:s")
            ]);
    }
}

//

function getMatchhistory($player_nick, $puuid){
    global $conn; 
    $current_time = new DateTime();
    $api_data = [];
    $db_data = [];
    try{
        $stmt = $conn->prepare("SELECT * FROM player WHERE nickname = ?");
        $stmt->execute([$player_nick]);
        $player = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($player){

            if ($player['last_updated'] === null) {
                // If 'last_updated' is null, set it to a very old date, e.g., 1970-01-01
                $last_updated = new DateTime('1970-01-01');
                echo "FUNGUJE 1";
            } else {
                // Otherwise, use the stored 'last_updated' value
                $last_updated = new DateTime($player['last_updated']);
                echo "FUNGUJE 2";
            }

            if ($current_time->getTimestamp() - $last_updated->getTimestamp() > 3600) { // 1 hour threshold
                // Fetch new matches from API
                $api_data = getMatchhistoryFromAPI($puuid, $last_updated);
                insertmatchdata($player_nick, $api_data);
                // Merge API data with DB data
                $db_data = fetchMatchesFromDB($player_nick);
                echo "FUNGUJE 3";
                return $db_data;
            } else {
                // Use cached data from DB
                return fetchMatchesFromDB($player_nick);
                echo "FUNGUJE 4";

            }
        } else {
            // Player does not exist, fetch all data from API
            $api_data = getMatchhistoryFromAPI($puuid);
             // Save player and matches to DB
             insertmatchdata($player_nick, $api_data);
             echo "FUNGUJE 5";
            return $api_data;
        }

    }catch(Exception $e){
        echo "<p>Chyba: {$e->getMessage()}</p>";
    }
}
//
function fetchMatchesfromDB($nickname){
global $conn;
$stmt = $conn->prepare("SELECT * FROM player_matches WHERE player_id = ?");
$stmt->execute([$nickname]);
$databasedata = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $databasedata;
}


?>