<?php
require_once "../Library/Database.php";
$conn = (new Database())->getConnection();

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

function fetchstreamers($role = null){
    global $conn;
    if (isset($role)){
        try {
            $stmt = $conn->prepare("SELECT * FROM streamer WHERE role = ?;");
            $stmt->execute([$role]);
            return $stmt->fetchAll();
        }catch(Exception $e){
            echo "<p>Chyba: {$e->getMessage()}</p>";
        }
    } else {
        try {
            $stmt = $conn->prepare("SELECT * FROM streamer;");
            $stmt->execute();
            return $stmt->fetchAll();
        }catch(Exception $e){
            echo "<p>Chyba: {$e->getMessage()}</p>";
        }
    }
}   

function removestreamer($streamername)
{
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM streamer WHERE streamername = ?;");
        $stmt->execute([$streamername]);
    }catch(Exception $e){
        echo "<p>Chyba: {$e->getMessage()}</p>";
    }

}





?>