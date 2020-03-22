<?php
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\SMTP;
use \PHPMailer\PHPMailer\Exception;

include_once '../../../vendor/autoload.php';
include_once '../../a_conect.php';

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

$mail->From = 'support@prizmarket.ru';
$mail->FromName = 'PRIZMarket';
$mail->addAddress($емаил);  // добавить получателя

$mail->WordWrap = 50;                 // автоматический перенос символов

$mail->Subject = 'Регистрация';
$mail->Body    = "&nbsp;&nbsp;Здравствуйте <b>{$логин}</b>, это письмо отправлено Вам для продолжения регистрации на сайте <span>PRIZMarket</span>.<br><br>&nbsp;&nbsp;На это письмо отвечать не нужно. Просто перейдите по ссылке ниже.<br><br>&nbsp;&nbsp;<a href='https://pokamojettak.sru'>https://pokamojettak.sru</a>";

if(!$mail->send()) {	
    echo 'Не смог отправить сообщение.';
    echo 'Ошибка: ' . $mail->ErrorInfo;
	$bot->sendMessage($admin_group, "Не смог отправить сообщение на почту.");
	//exit('ok');
} else {
    echo "<b>Сообщение отправлено!</b><br><br>Проверьте почту, перейдите по присланной Вам ссылке для окончания регистрации. Если письмо не пришло проверьте папку СПАМ.<br><br>После окончания регистрации зайдите в личный кабинет.";
	$bot->sendMessage($admin_group, "Сообщение отправлено на почту!");
}

?>
