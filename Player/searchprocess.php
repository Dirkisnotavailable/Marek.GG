<?php

session_start();
// https://europe.api.riotgames.com/riot/account/v1/accounts/by-riot-id/aah/help?api_key=RGAPI-88d91615-a9eb-4813-873a-47e50df212cc
$main_url = "https://europe.api.riotgames.com" ;
$api_key = "RGAPI-88d91615-a9eb-4813-873a-47e50df212cc";
$regionIndex = $_POST['region'];
$searchname = $_POST['playername'];
$searchname = trim($searchname);
$searchname = explode("#", $searchname);
$regions = [
    "https://eun1.api.riotgames.com",
    "https://euw1.api.riotgames.com",
    "https://jp1.api.riotgames.com",
    "https://na1.api.riotgames.com", 
    "https://kr.api.riotgames.com"
];
$rankeddatasolo;
$rankeddataflex;
$ch = curl_init();

function getPuuid($searchname, $regions, $regionIndex)
{
    $player_name = $searchname[0];
    $player_tag = $searchname[1];
    global $server_url;
    $server_url = $regions[$regionIndex];
    global $main_url;
    global $api_key;
    global $ch;
    $fullurl = "$main_url/riot/account/v1/accounts/by-riot-id/$player_name/$player_tag?api_key=$api_key";

    curl_setopt($ch, CURLOPT_URL, $fullurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5); 
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true); 
    $response = json_decode(curl_exec($ch));
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode != 200)   // VELMI DOLEZITE AK JE RESPONSE CODE 200 -> UKAZE NICK HRACA INAK ZLE
    {
        header('Location: Player/errorpage.php');
        exit;
    } else
    {   
        global $puuid;
        $puuid = $response->puuid; //PUUID
        searchPlayer();
    }

}
function searchPlayer()
{
    global $server_url;
    global $api_key;
    global $puuid;
    global $ch;

    $fullurl = "$server_url/lol/summoner/v4/summoners/by-puuid/$puuid?api_key=$api_key";
    curl_setopt($ch, CURLOPT_URL, $fullurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5); 
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true); 
    $response = json_decode(curl_exec($ch));
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode != 200)
    {
        header('Location: Player/errorpage.php');
        exit;
    }

    global $summonerlevel;
    $summonerlevel = $response->summonerLevel; //LEVEL HRACA
    global $profileIconId;
    $profileIconId = $response->profileIconId; //IKONKA
    // echo $summonerlevel;
    global $summonerid;
    $summonerid = $response->id; //Summonerid
    getPlayerData();


}

function getPlayerData()
{
    global $summonerid, $server_url, $api_key, $ch;
    $fullurl = "$server_url/lol/league/v4/entries/by-summoner/$summonerid?api_key=$api_key";
    // echo $fullurl;
    curl_setopt($ch, CURLOPT_URL, $fullurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $response = json_decode($response);
    global $rankeddatasolo, $rankeddataflex;
    if (isset($response[1])) {
        if (isset($response[0]->queuetype) && $response[0]->queuetype == "RANKED_SOLO_5x5") {
            $rankeddatasolo = $response[0];
            $rankeddataflex = $response[1];
        } else {
            $rankeddatasolo = $response[1];
            $rankeddataflex = $response[0];
        }
    } else {
        $rankeddatasolo = $response[0];
    }
    global $player_wins_flex, $player_losses_flex, $player_rank_tier_flex, $player_rank_flex, $player_LP_flex, $player_wins_solo, $player_losses_solo, $player_rank_solo, $player_rank_tier_solo, $player_rank_solo, $player_LP_solo;
    // SoloQ variables
    $player_wins_solo = $rankeddatasolo->wins;
    $player_losses_solo =  $rankeddatasolo->losses;
    $player_rank_tier_solo = $rankeddatasolo->tier;
    $player_rank_solo = $rankeddatasolo->rank;
    $player_LP_solo = $rankeddatasolo->leaguePoints;
    // FlexQ variables
    $player_wins_flex = $rankeddataflex->wins;
    $player_losses_flex = $rankeddataflex->losses;
    $player_rank_tier_flex = $rankeddataflex->tier;
    $player_rank_flex = $rankeddataflex->rank;
    $player_LP_flex = $rankeddataflex->leaguePoints;
}
    getPuuid($searchname, $regions,$regionIndex);

     curl_close($ch);
     $_SESSION['nickname'] = htmlspecialchars($searchname[0] . "#" . $searchname[1]);
     $_SESSION['level'] = $summonerlevel;
     $_SESSION['wins_solo'] = $player_wins_solo;
     $_SESSION['losses_solo'] = $player_losses_solo;
     $_SESSION['tier_solo'] = $player_rank_tier_solo;
     $_SESSION['rank_solo'] = $player_rank_solo;
     $_SESSION['lp_solo'] = $player_LP_solo;
     $_SESSION['wins_flex'] = $player_wins_flex;
     $_SESSION['losses_flex'] = $player_losses_flex;
     $_SESSION['tier_flex'] = $player_rank_tier_flex;
     $_SESSION['rank_flex'] = $player_rank_flex;
     $_SESSION['lp_flex'] = $player_LP_flex;
     $_SESSION['iconid'] = $profileIconId;

     require_once "functions.php";
     require_once "matchhistory.php";
     echo "<pre>";
     var_dump(getMatchhistory(htmlspecialchars($searchname[0] . "#" . $searchname[1]), $puuid));
     echo "</pre>";
     insertdata(htmlspecialchars($searchname[0] . "#" . $searchname[1]), $summonerlevel, $profileIconId);
     //header("Location: Player/playerpage.php");
    ?>