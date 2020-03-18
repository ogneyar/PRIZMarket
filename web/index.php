<?php
include_once '../vendor/autoload.php';	
include_once 'a_conect.php';
include_once 'site_pzm/pzmarket.php';

//exit('ok');

$token = $tokenMARKET;
$tg = new \TelegramBot\Api\BotApi($token);

$id_bota = strstr($token, ':', true);	

// Группа администрирования бота (Админка)
$admin_group = $admin_group_market;

// Канал, где появляются новые лоты
$channel = $channel_market;

//$tg->sendMessage($admin_group, "йээ");

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />	
	<title>PRIZMarket!</title>
	<?include_once 'site_pzm/site_files/head.php';?>
	
	<style type="text/css">
		@media (min-width: 700px) {
		nav a:first-child, nav#fixed a:first-child {
			border-top: 5px solid rgba(255,235,59);
		}} 
	</style>
	
</head>
<body>
	<header>
		<?include_once 'site_pzm/site_files/header.php';?>
	</header>
	<nav>
		<?include_once 'site_pzm/site_files/nav.php';?>
	</nav>
	<div id="slideMenu">Моё)</div>
	<div id="wrapper">
		<div id="TopCol">		
			<?include_once 'site_pzm/site_files/wrapper-topCol.php';?>
		</div>
		<div id="leftCol">		
			<?include_once 'site_pzm/site_files/wrapper-leftCol.php';?>
		</div>
		<div id="rightCol">
			<?include_once 'site_pzm/site_files/wrapper-rightCol.php';?>
		</div>
	</div>
	<footer>
		<?include_once 'site_pzm/site_files/footer.php';?>
	</footer>
</body>
</html>
