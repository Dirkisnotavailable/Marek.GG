<?php 
//----------------


function getMatchhistory(){
   global $main_url, $puuid, $api_key, $ch, $m, $alldata;
   //Ziskat match id
   $fullurl = "$main_url/lol/match/v5/matches/by-puuid/$puuid/ids?start=0&count=20&api_key=$api_key";
   curl_setopt($ch, CURLOPT_URL, $fullurl);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_TIMEOUT, 5);
   curl_setopt($ch, CURLOPT_FRESH_CONNECT, true); 
   $matches_id = curl_exec($ch);
   $matches_id = json_decode($matches_id);
   //Ziskat samotne data
   $match_url = "$main_url/lol/match/v5/matches/$matches_id[$m]?api_key=$api_key";
   curl_setopt($ch, CURLOPT_URL, $match_url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_TIMEOUT, 5);
   curl_setopt($ch, CURLOPT_FRESH_CONNECT, true); 
   $match_data = curl_exec($ch);
   $match_data = json_decode($match_data);
   $participants = $match_data->metadata->participants;
   $pid =  [];
   $playerstats = [];
   for ($i = 0; $i < 10; $i++)
   {
       if($participants[$i] == $puuid)
       {
           $find = $i;
           break;           
       }
   }

   $pid = $match_data->info->participants[$find];

   array_push($playerstats, $pid->championName, $pid->kills, $pid->deaths, $pid->assists, $pid->totalMinionsKilled+$pid->neutralMinionsKilled);
   if ($pid->win != false)
   {
       array_push($playerstats, "win");
   } else {
       array_push($playerstats, "loss");
   }
   
   $player_items = [];
   array_push($player_items, $pid->item0, $pid->item1, $pid->item2, $pid->item3, $pid->item4, $pid->item5, $pid->item6);
   $match_time = $match_data->info->gameDuration;
   $match_minutes = floor($match_time/60);
   $match_seconds = $match_time%60;
   $summoner_spell1 = $pid->summoner1Id;
   $summoner_spell2 = $pid->summoner2Id;

   $runes_url = "http://ddragon.leagueoflegends.com/cdn/14.23.1/data/en_US/runesReforged.json";
   curl_setopt($ch, CURLOPT_URL, $runes_url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_TIMEOUT, 5); 
   curl_setopt($ch, CURLOPT_FRESH_CONNECT, true); 
   $runes_data = curl_exec($ch);
   $runes_data = json_decode($runes_data);
   for($y=0;$y<5;$y++){

       if ($pid->perks->styles[0]->style == $runes_data[$y]->id) {
           for ($i = 0; $i < count($runes_data[$y]->slots[0]->runes); $i++) {
               if ($pid->perks->styles[0]->selections[0]->perk == $runes_data[$y]->slots[0]->runes[$i]->id) {
                   $playermainrune = $runes_data[$y]->slots[0]->runes[$i]->name;
                   echo $playermainrune;
                   break;
               }
           }
       } 
   }

   for($y=0;$y<5;$y++){

       if($pid->perks->styles[1]->style == $runes_data[$y]->id)
       {
           $playersecondaryrune = $runes_data[$y]->name;
       }
   }

   $blueteam = [];
   $redteam = [];
   $blueteamchampions = [];
   $redteamchampions = [];
   //Zapisanie champov a nickov hracov do blue a red side teamu
   for($i=0;$i<10;$i++)
   {
       if($i<5)
       {
           $temp_gamename = $match_data->info->participants[$i]->riotIdGameName;
           $temp_idtagline = $match_data->info->participants[$i]->riotIdTagline;
           $temp_gamename = "$temp_gamename#$temp_idtagline";             
           array_push($blueteam, $temp_gamename);
           array_push($blueteamchampions, $match_data->info->participants[$i]->championName);
       } else 
       {
           $temp_gamename = $match_data->info->participants[$i]->riotIdGameName;
           $temp_idtagline = $match_data->info->participants[$i]->riotIdTagline;
           $temp_gamename = "$temp_gamename#$temp_idtagline";
           array_push($redteam, $temp_gamename);
           array_push($redteamchampions, $match_data->info->participants[$i]->championName);
       }
   }
   $match_info = [
       'playerStats' => $playerstats, 
       'items' => $player_items,
       'runes' => [
           'mainRune' => $playermainrune,
           'secondaryRune' => $playersecondaryrune
       ],
       'matchTime' => "$match_minutes:$match_seconds",
       'blueTeam' => $blueteam,
       'redTeam' => $redteam,
       'summonerspell1' => $summoner_spell1,
       'summonerspell2' => $summoner_spell2,
       'blueteamchampions' => $blueteamchampions,
       'redteamchampions' => $redteamchampions,
   ];
   array_push($alldata, $match_info);
}
$alldata = [];  


for($m = 0; $m < 20; $m++)
{
   getMatchhistory();
}

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
$_SESSION['mdata'] = $alldata;
header("Location: Player/playerpage.php");
?>