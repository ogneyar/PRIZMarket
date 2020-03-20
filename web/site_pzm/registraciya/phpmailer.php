<?php
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\SMTP;
use \PHPMailer\PHPMailer\Exception;

include_once '../../../vendor/autoload.php';
include_once '../../a_conect.php';

$mail = new PHPMailer;

$mail->isSMTP();                      // Set mailer to use SMTP
$mail->Host = $mail_smtp_server;      // Specify main and backup SMTP servers
$mail->SMTPAuth = true;               // Enable SMTP authentication
$mail->Username = $mail_smtp_login;   // SMTP username
$mail->Password = $mail_smtp_pass;    // SMTP password
$mail->SMTPSecure = 'tls';            // Enable encryption, only 'tls' is accepted

$mail->From = 'support@prizmarket.ru';
$mail->FromName = 'PRIZMarket';
$mail->addAddress($емаил);  // добавить получателя

$mail->WordWrap = 50;                 // автоматический перенос символов

$mail->Subject = 'Hello';
$mail->Body    = 'Testing some Mailgun awesomness';

if(!$mail->send()) {	
    echo 'Не смог отправить сообщение.';
    echo 'Ошибка: ' . $mail->ErrorInfo;
	$bot->sendMessage($admin_group, "Не смог отправить сообщение.");
	//exit('ok');
} else {
    echo "Сообщение отправлено!";
	$bot->sendMessage($admin_group, "Сообщение отправлено!");
}

?>
