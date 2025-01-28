<?php
require_once '../Library/sessionstart.php';
require_once '../Library/Database.php';
$conn = (new Database())->getConnection();


//Tabulku so vsetkymi uzivatelmi
function showusers()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll();
    echo '<table class="Table">
        <thead>
<tr>
<th>ID</th>
<th>nickname</th>
<th>password</th>
<th>email</th>
<th>country</th>
<th>role</th>
<th>date_created</th>
<th>Actions</th>
</tr>
</thead>
<tbody>';
    foreach ($users as $user) {
    echo "<tr>";
    echo "<td>" . $user['id'] . "</td>";
    echo "<td>" . $user['nickname'] . "</td>";
    echo "<td>" . $user['password'] . "</td>";
    echo "<td>" . $user['email'] . "</td>";
    echo "<td>" . $user['country'] . "</td>";
    echo "<td>" . $user['role'] . "</td>";
    echo "<td>" . $user['date_created'] . "</td>";
    echo "<td> <a href='resetpassword.php?id=" . $user['id'] . "'>Reset Password</a></td>";
    echo "</tr>"; }
    echo "</table>";
}

//Tabulku so vsetkymi streamermi


//Vsetci streameri a moznost ich pridavat
function showstreamers(){
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM streamer");
    $stmt->execute();
    $streamers = $stmt->fetchAll();
    echo '<table class="Table">
        <thead>
<tr>
<th>streamerID</th>
<th>streamername</th>
<th>role</th>
<th>streamericon</th>
</tr>
</thead>
<tbody>';
    foreach ($streamers as $streamer) {
    echo "<tr>";
    echo "<td>" . $streamer['streamerid'] . "</td>";
    echo "<td>" . $streamer['streamername'] . "</td>";
    echo "<td>" . $streamer['role'] . "</td>";
    echo "<td>" . $streamer['streamericon'] . "</td>";
    echo "</tr>"; }
    echo "</table>";
}

function showStreamerCards() {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM streamer");
    $stmt->execute();
    $streamers = $stmt->fetchAll();
    echo '<div class="streamer-cards">';
    foreach ($streamers as $streamer) {
        echo '<div class="card">';
        echo '<img src="' . $streamer['streamericon'] . '" alt="' . $streamer['streamername'] . '">';
        echo '<h2>' . $streamer['streamername'] . '</h2>';
        echo '<p>Role: ' . $streamer['role'] . '</p>';
        echo '</div>';
    }
    echo '</div>';
}
function showUserCards() {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll();
    echo '<div class="user-cards">';
    foreach ($users as $user) {
        echo '<div class="card">';
        echo '<img src="https://ui-avatars.com/api/?background=random&name=' . urlencode($user['nickname']) . '&size=64" alt="Avatar">';
        echo '<h2>' . htmlspecialchars($user['nickname']) . '</h2>';
        echo '<p>' . htmlspecialchars($user['role']) . '</p>';
        echo '</div>';
    }
    echo '</div>';
}
function getTotalUsers() {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getTotalStreamers() {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM streamer");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getNewUsersThisMonth() {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE MONTH(date_created) = MONTH(CURRENT_DATE()) AND YEAR(date_created) = YEAR(CURRENT_DATE())");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getNumberofSearches() {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM player");
    $stmt->execute();   
    return $stmt->fetchColumn();
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

function getStreamerbynick($streamername)
{
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM streamer WHERE streamername = ?;");
        $stmt->execute([$streamername]);
        return $stmt->fetch();
    } catch(Exception $e)
    {
        echo "<p>Chyba: {$e->getMessage()}</p>";
    }
}

function insertuser($nickname, $password, $email, $role)
{
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO users (nickname, password, email, country, role) VALUES (?, ?, ?, DEFAULT, ?);");
        $stmt->execute([$nickname, $password, $email, $role]);
    } catch(Exception $e)
    {
        echo "<p>Chyba: {$e->getMessage()}</p>";
    }
}

function removeuser($nickname)
{
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM users WHERE nickname = ?;");
        $stmt->execute([$nickname]);
    }catch(Exception $e){
        echo "<p>Chyba: {$e->getMessage()}</p>";
    }

}   

function getUserByEmail($email) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getuser($nickname) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE nickname = ?;");
        $stmt->execute([$nickname]);
        return $stmt->fetch();
    } catch (Exception $e) {
        echo "<p>Chyba: {$e->getMessage()}</p>";
    }
}


?>