<?php
require_once "../Library/Database.php";
$conn = (new Database())->getConnection();

function getuser($nickname) {
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE LOWER(nickname) = LOWER(?);");
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
        $stmt = $conn->prepare("DELETE FROM users WHERE LOWER(nickname) = LOWER(?);");
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
            echo "User successfully added!<br>";
            echo "Stored Hashed Password: " . $password . "<br>";
        }catch(Exception $e){
            echo "<p>Chyba: {$e->getMessage()}</p>";
        }
    }
}

function logout()
{
    session_start();
    session_unset();
    session_destroy();
    header("Location: /Testik/index.php");
}

?>