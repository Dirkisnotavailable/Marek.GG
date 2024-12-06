    <?php 
    //----------------
    function fetchPlayerRunes($player_stats) {
        // Runes API URL
        $runes_url = "http://ddragon.leagueoflegends.com/cdn/14.23.1/data/en_US/runesReforged.json";
        $runes_response = file_get_contents($runes_url);
        $runes_data = json_decode($runes_response);

        // Find main rune
        $main_rune = null;
        $secondary_rune = null;
        foreach ($runes_data as $rune_tree) {
            if ($rune_tree->id == $player_stats->perks->styles[0]->style) {
                foreach ($rune_tree->slots[0]->runes as $rune) {
                    if ($rune->id == $player_stats->perks->styles[0]->selections[0]->perk) {
                        $main_rune = $rune->name;
                        break;
                    }
                }
            }
            if ($rune_tree->id == $player_stats->perks->styles[1]->style) {
                $secondary_rune = $rune_tree->name;
            }
        }

        return [
            'mainRune' => $main_rune,
            'secondaryRune' => $secondary_rune,
        ];
    }
    
    function extractTeamData($participants, $start, $end) {
        $team_data = [];
        for ($i = $start; $i < $end; $i++) {
            $team_data[] = [
                'playerName' => $participants[$i]->riotIdGameName . "#" . $participants[$i]->riotIdTagline,
                'champion' => $participants[$i]->championName,
            ];
        }
        return $team_data;
    }

    function getMatchhistoryFromAPI($puuid, $last_updated = null, $match_limit = 10){
        $main_url = "https://europe.api.riotgames.com" ;
        $api_key = "RGAPI-88d91615-a9eb-4813-873a-47e50df212cc";
        $ch = curl_init();
        $update = false;
    global $m, $alldata;
    //Ziskat match id
    $match_ids_url = "$main_url/lol/match/v5/matches/by-puuid/$puuid/ids?start=0&count=$match_limit&api_key=$api_key";
    if ($last_updated) {
        $gamestart = $last_updated->getTimestamp();
        $gamestart = $gamestart - 3600;
        $match_ids_url .= "&startTime=" . $gamestart;
        $update = true;
        echo $match_ids_url;
    } 
    curl_setopt($ch, CURLOPT_URL, $match_ids_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, true); 
    $matches_id_response = curl_exec($ch);
    $matches_id = json_decode($matches_id_response, true);
    //Ziskat samotne data
    $matches_data = [];
    foreach ($matches_id as $match_id) {
        $match_url = "$main_url/lol/match/v5/matches/$match_id?api_key=$api_key";
        curl_setopt($ch, CURLOPT_URL, $match_url);
        $match_response = curl_exec($ch);
        $match_data = json_decode($match_response);
        if (empty($match_data)) {
            continue; // Skip if match data is not found
        }
        $participants = $match_data->metadata->participants;
        if (is_array($participants)) {
            // Find the index of the player in the participants array
            $player_index = array_search($puuid, $participants);
            if ($player_index === false) {
                continue; // If player not found in participants, skip this match
            }
        $player_stats = $match_data->info->participants[$player_index];
        $match_info = [
            'playerStats' => [
                'champion' => $player_stats->championName,
                'kills' => $player_stats->kills,
                'deaths' => $player_stats->deaths,
                'assists' => $player_stats->assists,
                'farm' => $player_stats->totalMinionsKilled + $player_stats->neutralMinionsKilled,
                'result' => $player_stats->win ? "win" : "loss",
            ],
            'items' => [
                $player_stats->item0,
                $player_stats->item1,
                $player_stats->item2,
                $player_stats->item3,
                $player_stats->item4,
                $player_stats->item5,
                $player_stats->item6,
            ],
            'matchTime' => gmdate("i:s", $match_data->info->gameDuration),
            'summonerSpells' => [
                $player_stats->summoner1Id,
                $player_stats->summoner2Id,
            ],
            'runes' => fetchPlayerRunes($player_stats),
            'blueTeam' => extractTeamData($match_data->info->participants, 0, 5),
            'redTeam' => extractTeamData($match_data->info->participants, 5, 10),
        ];
    }

        if ($update)
        {
            array_unshift($matches_data, $match_info);
        } else {
            $matches_data[] = $match_info;
        }

    }
    curl_close($ch);
    return $matches_data;
    }


 /*   try {
        $puuid = "8WsoYg3O13bzTBYh5G1dN77UScxhgMr6P1bCVPF6OzGlR8yzvoebR8gxzLNk38Bc9V8Iq6tLuvCHWA"; 
        $match_limit = 10; 
        $match_history = getMatchhistoryFromAPI($puuid, $match_limit);
        echo "<pre>";
        var_dump($match_history); 
         "</pre>";

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
        */
      ?>