<?php
//include_once '../../../vendor/autoload.php';	
include_once '../../a_conect.php';

// Подключаем библиотеку с классом Bot
include_once '../../myBotApi/Bot.php';
//exit('ok');
$token = $tokenMARKET;
// Создаем объект бота
$bot = new Bot($token);

$id_bota = strstr($token, ':', true);	
// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ПЕРЕМЕННЫХ
include '../../myBotApi/Variables.php';

$admin_group = $admin_group_market;


$client  = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$remote  = @$_SERVER['REMOTE_ADDR'];
 
if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
else $ip = $remote;


if ($_GET['st'] == 'zero') $bot->sendMessage($admin_group, "Кто-то желает зарегаться на сайте!\nего IP: {$ip}");

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />	
	<title>Регистрация на PRIZMarket!</title>
	<?include_once '../site_files/head.php';?>
	<style type="text/css"></style>
</head>
<body>
	<header>
		<?include_once '../site_files/header.php';?>
	</header>
	<nav>
		<?include_once '../site_files/nav.php';?>
	</nav>
	<div id="slideMenu">Моё детище, а не просто сайт!</div>
	<div id="wrapper">
		<div id="TopCol">		
			<?include_once '../site_files/wrapper-topCol.php';?>
		</div>
		<div id="leftCol">		
			<?include_once '../site_files/wrapper-leftCol-registraciya.php';?>
		</div>
		<div id="rightCol">
			<?include_once '../site_files/wrapper-rightCol.php';?>
		</div>
	</div>
	<footer>
		<?include_once '../site_files/footer.php';?>
	</footer>
</body>
</html>
