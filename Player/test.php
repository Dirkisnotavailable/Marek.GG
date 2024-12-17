<?php
require_once 'functions.php';
require_once 'matchhistory.php';

try {
    $puuid = "8WsoYg3O13bzTBYh5G1dN77UScxhgMr6P1bCVPF6OzGlR8yzvoebR8gxzLNk38Bc9V8Iq6tLuvCHWA"; 
    $match_limit = 10; 
    $match_history = getMatchhistoryFromAPI($puuid);
    echo "<pre>";
    var_dump($match_history); // Display the match history
    echo "</pre>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


?>