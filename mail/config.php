<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__.'/phpmailer/Exception.php';
require __DIR__.'/phpmailer/PHPMailer.php';
require __DIR__.'/phpmailer/SMTP.php';

function sendMail($to,$subject,$message){

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'ezgierdogan.439@gmail.com';
    $mail->Password = 'lkbsrdxzgrtyymos ';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('ezgierdogan.439@gmail.com','Smart City');
    $mail->addAddress($to);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();
}
