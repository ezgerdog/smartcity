<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__.'/phpmailer/Exception.php';
require __DIR__.'/phpmailer/PHPMailer.php';
require __DIR__.'/phpmailer/SMTP.php';

function sendStatusMail($to, $subject, $message){

    $mail = new PHPMailer(true);

    try{
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "SMARTCITYMAIL@gmail.com";     // ← BUNU DEĞİŞTİRECEĞİZ
        $mail->Password = "APP_PASSWORD";                // ← BUNU DEĞİŞTİRECEĞİZ
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;

        $mail->setFrom("SMARTCITYMAIL@gmail.com","Smart City Municipality");
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
    } catch(Exception $e){}
}
