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

function removeuser($nickname)
{
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM users WHERE nickname = ?;");
        $stmt->execute([$nickname]);
        return "User successfully removed!";
    }catch(Exception $e){
        echo "<p>Chyba: {$e->getMessage()}</p>";
    }

}

function adduser($nickname, $password, $email, $country)
{
    global $conn;
    $user = getuser($nickname);
    if (!empty($user)) {
        echo "User with that username already exists!";
        exit;
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO users (nickname, password, email, country) VALUES (?, ?, ?, ?);");
            $stmt->execute([$nickname, $password, $email, $country]);
            return "User successfully added!";
        }catch(Exception $e){
            echo "<p>Chyba: {$e->getMessage()}</p>";
        }
    }
}



?>