<?php
if (!$_COOKIE['login']) header('Location: /site_pzm/vhod/index.php');
if (!$_COOKIE['token']) header('Location: /site_pzm/vhod/index.php');
$логин = $_COOKIE['login'];
$токен = $_COOKIE['token'];
include_once "../site_files/functions.php";
// Открыл базу данных, в конце обязательно надо закрыть

// сходятся ли логин и токен
$всё_норм = _сравни_токен_и_логин($логин, $токен);
if (!$всё_норм) include_once 'exit.php';

include_once 'zayavki_pzmarket.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title>Ваши заявки на PRIZMarket!</title>
	<?include_once '../site_files/head.php';?>	
</head>
<body>
	<header>
		<?include_once '../site_files/header.php';?>
	</header>
	<div id="lk_menu">
		<?include_once 'index-lk_menu.php';?>
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
			<?include_once 'zayavki-leftCol.php';?>
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
<?
// закрываем подключение 
$mysqli->close();
?>