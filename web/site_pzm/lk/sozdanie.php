<?php
include_once '../../a_conect.php';
include_once '../../myBotApi/Bot.php';
//exit('ok');
$token = $tokenSite;
$bot = new Bot($token);
$id_bota = strstr($token, ':', true);	
include_once '../../myBotApi/Variables.php';
$admin_group = $admin_group_Site;
$админка = $admin_group;
$мастер = $master;

$bot->sendMessage($мастер, "Привеееет");	

if (!$_COOKIE['login']) header('Location: /site_pzm/vhod/index.php');
//else $json = json_encode($_COOKIE['login']);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title>Ваши заявки на PRIZMarket!</title>
	<?include_once '../site_files/head.php';?>		
	
	<script type="text/javascript" src="sozdanie.js"></script>	
	
</head>
<body>
	<header>
		<?include_once '../site_files/header.php';?>
	</header>
	<div id="lk_menu">
		<?include_once 'lk.php';?>
	</div>
	<nav>
		<?include_once '../site_files/nav.php';?>
	</nav>
	<div id="slideMenu">Моё детище, а не просто сайт!</div>
	<div id="wrapper">
		<div id="TopCol">
			<?include_once '../site_files/wrapper-topCol.php';?>
		</div>
		<div id="leftCol">
			<?include_once 'wrapper-leftCol-sozdanie.php';?>
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
