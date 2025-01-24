<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../Library/PHPMailer/src/Exception.php';
require '../Library/PHPMailer/src/PHPMailer.php';
require '../Library/PHPMailer/src/SMTP.php';
require_once "../Library/Database.php";
$conn = (new Database())->getConnection();

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
            $currentDate = date('Y-m-d H:i:s');
            $stmt = $conn->prepare("INSERT INTO users (nickname, password, email, country, date_created) VALUES (?, ?, ?, ?, ?);");
            $stmt->execute([$nickname, $password, $email, $country, $currentDate]);
            return "User successfully added!";
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

function sendemail($username, $email, $body)
{
//Posielanie emailu cez phpmailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;  
        $mail->Port = 465;
        $mail->Username = "marekdotgg@gmail.com";
        $mail->Password = "bysd kjyd srbi nptp";
        $mail->setFrom('marekdotgg@gmail.com');
        $mail->addAddress($email);  
        $mail->isHTML(true);
        $mail->Subject = 'Marek.GG - Successful registration';
        $mail->Body = $body;
    
         $mail->send();
        echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
}

?>