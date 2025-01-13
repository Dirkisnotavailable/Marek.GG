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

function insertstreamer($streamername, $streamerid, $streamericon, $role){
    global $conn;
    try {
        $stmt = $conn->prepare("
        INSERT INTO streamer (streamerid, streamername, streamericon, role)
        VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE 
            streamericon = VALUES(streamericon), 
            role = VALUES(role);");
    $stmt->execute([$streamerid, $streamername, $streamericon, $role]);
    }catch(Exception $e){
        echo "<p>Chyba: {$e->getMessage()}</p>";
    }
}

function fetchstreamers(){
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM streamer;");
        $stmt->execute();
        return $stmt->fetchAll();
    }catch(Exception $e){
        echo "<p>Chyba: {$e->getMessage()}</p>";
    }


}   





?>