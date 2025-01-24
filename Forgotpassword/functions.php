<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../Library/PHPMailer/src/Exception.php';
require '../Library/PHPMailer/src/PHPMailer.php';
require '../Library/PHPMailer/src/SMTP.php';
require_once "../Library/Database.php";
$conn = (new Database())->getConnection();
function getuser($email)
{
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?;");
        $stmt->execute([$email]);
        return $stmt->fetch();
    } catch (Exception $e) {
        echo "<p>Chyba: {$e->getMessage()}</p>";
    }
}

function getuserbyid($id)
{
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?;");
        $stmt->execute([$id]);
        return $stmt->fetch();
    } catch (Exception $e) {
        echo "<p>Chyba: {$e->getMessage()}</p>";
    }
}

function createpasswordreset($userid, $code)
{
    global $conn;
    try {
        $stmt = $conn->prepare("INSERT INTO password_resets (user_id, code) VALUES (?, ?);");
        $stmt->execute([$userid, $code]);
    } catch (Exception $e) {
        echo "<p>Chyba: {$e->getMessage()}</p>";
    }
}

function checkcode($code)
{
    global $conn;
    try {
        $stmt = $conn->prepare("SELECT * FROM password_resets WHERE code = ? AND created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR);");
        $stmt->execute([$code]);
        return $stmt->fetch();
    } catch (Exception $e) {
        echo "<p>Chyba: {$e->getMessage()}</p>";
    }
}

function deleteCode($code)
{
    global $conn;
    try {
        $stmt = $conn->prepare("DELETE FROM password_resets WHERE code = ?;");
        $stmt->execute([$code]);
    } catch (Exception $e) {
        echo "<p>Chyba: {$e->getMessage()}</p>";
    }
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
        $mail->Subject = 'Marek.GG - Reset password';
        $mail->Body = $body;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
