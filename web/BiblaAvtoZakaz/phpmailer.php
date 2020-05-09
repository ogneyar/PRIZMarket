<?php
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\SMTP;
use \PHPMailer\PHPMailer\Exception;

include_once '../../vendor/autoload.php';
include_once '../a_conect.php';

$mail = new PHPMailer;

$mail->isSMTP();                      // Set mailer to use SMTP
$mail->Host = $smtp_server;      // Specify main and backup SMTP servers
$mail->Port = $smtp_port;
$mail->SMTPAuth = true;               // Enable SMTP authentication
$mail->Username = $smtp_login;   // SMTP username
$mail->Password = $smtp_pass;    // SMTP password
$mail->SMTPSecure = 'tls';            // Enable encryption, only 'tls' is accepted

$mail->CharSet = "utf-8";
$mail->IsHTML(true); 

$mail->From = 'prizmarket@sibnet.ru';
$mail->FromName = 'PRIZMarket';
$mail->addAddress($емаил);  // добавить получателя

$mail->WordWrap = 50;                 // автоматический перенос символов

$mail->Subject = 'Регистрация';
$mail->Body    = $body;

if(!$mail->send()) {	
    echo 'Не смог отправить сообщение.';
    echo 'Ошибка: ' . $mail->ErrorInfo;
	$bot->sendMessage($admin_group, "Не смог отправить сообщение на почту.");
	//exit('ok');
} else {
    echo $ответное_сообщение;
	$bot->sendMessage($admin_group, "Сообщение отправлено на {$емаил}!");
}

?>
