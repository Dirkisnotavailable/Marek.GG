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
        INSERT INTO player (id, nickname, level, icon)
        VALUES (null, ?, ?, ?)
        ON DUPLICATE KEY UPDATE 
            level = VALUES(level), 
            icon = VALUES(icon)");
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
        $matchid = $match['matchid'];
        $gamestart = $match['gamestart'];

        $stmt = $conn->prepare("
            INSERT INTO player_matches 
            (match_id, player_id, champion, 
            summoner1, summoner2, rune_primary, 
            rune_secondary, kills, deaths, 
            assists, CS, item1, 
            item2, item3, item4, 
            item5, item6, item7,
            result, match_time, gamestart)
            VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->execute([
                $matchid,
                $player_nick,
                $player_stats['champion'],                   // champion
                $summoner_spells[0],                         // summoner1
                $summoner_spells[1],                         // summoner2
                $runes['mainRune'],                          // rune_primary
                $runes['secondaryRune'],                     // rune_secondary
                $player_stats['kills'],                      // kills
                $player_stats['deaths'],                     // deaths
                $player_stats['assists'],                    // assists
                $player_stats['farm'],                       // CS 
                $items[0],                                   // item1
                $items[1],                                   // item2
                $items[2],                                   // item3
                $items[3],                                   // item4
                $items[4],                                   // item5
                $items[5],                                   // item6
                $items[6],
                $player_stats['result'],
                $match_time,
                $gamestart,
            ]);
    }
}

//

function getMatchhistory($player_nick, $puuid, $summonerlevel, $profileIconId){
    global $conn; 
    $current_time = new DateTime();
    $api_data = [];
    $db_data = [];
    try{
        $stmt = $conn->prepare("SELECT * FROM player WHERE nickname = ?");
        $stmt->execute([$player_nick]);
        $player = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($player){

            $stmt = $conn->prepare("SELECT created_at FROM player_matches where player_id = ? order by created_at desc limit 1");
            $stmt->execute([$player_nick]);
            $gamestart = $stmt->fetch(PDO::FETCH_ASSOC);

            if($gamestart){
                $last_updated = (new DateTime($gamestart['created_at']))->getTimestamp();
            } else {
                $last_updated = (new DateTime('1970-01-01'))->getTimestamp();
            }
                $current_time = $current_time->getTimestamp();
            #echo $current_time - $last_updated->getTimestamp();
            if ($current_time - $last_updated > 3600) { // 1/2 hour 
                //FETCH Z API DO DB
                $api_data = getMatchhistoryFromAPI($puuid, $last_updated);
                insertmatchdata($player_nick, $api_data);
                $db_data = fetchMatchesFromDB($player_nick);
                return $db_data;
            } else {
                // FETCH Z DB
                return fetchMatchesFromDB($player_nick);
            }
        } else {
            // KED HRAT NEEXISTUJE
            $api_data = getMatchhistoryFromAPI($puuid);
             // SAVE DO DB
             insertdata($player_nick, $summonerlevel, $profileIconId);
             insertmatchdata($player_nick, $api_data);
            return $api_data;
        }

    }catch(Exception $e){
        echo "<p>Chyba: {$e->getMessage()}</p>";
    }
}
//
function fetchMatchesfromDB($nickname){
global $conn;
$stmt = $conn->prepare("SELECT * FROM player_matches WHERE player_id = ? order by gamestart desc");
$stmt->execute([$nickname]);
$databasedata = $stmt->fetchAll(PDO::FETCH_ASSOC);
return $databasedata;
}

function getchampionWinrate($nickname){
    global $conn;
    $stmt = $conn->prepare("SELECT champion, COUNT(*) AS game_count FROM (SELECT champion FROM player_matches WHERE player_id = ? AND result = 'win' ORDER BY gamestart DESC LIMIT 20) AS recent_matches GROUP BY champion ORDER BY game_count DESC;");
    $stmt->execute([$nickname]);
    $hrychampov = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $hrychampov;
}

function getchampiongames($nickname){
    global $conn;
    $stmt = $conn->prepare("SELECT champion, COUNT(*) AS game_count FROM (SELECT champion FROM player_matches WHERE player_id = ? ORDER BY gamestart DESC LIMIT 20) AS recent_matches GROUP BY champion ORDER BY game_count DESC;");
    $stmt->execute([$nickname]);
    $vyhrychampov = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $vyhrychampov;
}


?>