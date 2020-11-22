<?php
if (!isset($_COOKIE['login'])) header('Location: /site_pzm/vhod/index.php');
if (!isset($_COOKIE['token'])) header('Location: /site_pzm/vhod/index.php');
$логин = $_COOKIE['login'];
$токен = $_COOKIE['token'];
include_once "../site_files/functions.php";
// Открыл базу данных, в конце обязательно надо закрыть

// сходятся ли логин и токен
$всё_норм = _сравни_токен_и_логин($логин, $токен);
if (!$всё_норм) include_once 'exit.php';
?>

<!DOCTYPE html>
<!-- <html xmlns="http://www.w3.org/1999/xhtml"> -->
<html lang="ru">
<head>
	<meta charset="utf-8" />
	<title>Ваши заявки на PRIZMarket!</title>
	<?php include_once '../site_files/head.php';?>	
</head>
<body>
	<header>
		<?php include_once '../site_files/header.php';?>
	</header>
	<div id="lk_menu">
		<?php include_once 'index-lk_menu.php';?>
	</div>
	<nav>
		<?php include_once '../site_files/nav.php';?>
	</nav>
	<div id="slideMenu">Моё детище, а не просто сайт!</div>
	<div id="wrapper">
		<div id="TopCol">
			<?php include_once '../site_files/wrapper-topCol.php';?>
		</div>
		<div id="leftCol">
			<?php 
			if (isset($_POST['repeat_delete']) && ($_POST['repeat_delete'] == "Повторить")) {
				include_once 'zayavki-repeat.php';
			}elseif (isset($_POST['repeat_delete']) && ($_POST['repeat_delete'] == "Удалить")) {
				include_once 'zayavki-delete_yes_no.php';
			}elseif (isset($_POST['done']) && ($_POST['done'] == "Да")) {
				include_once 'zayavki-delete.php';
			}else include_once 'zayavki-leftCol.php';
			?>
		</div>
		<div id="rightCol">
			<?php include_once '../site_files/wrapper-rightCol.php';?>
		</div>
	</div>
	<footer>
		<?php include_once '../site_files/footer.php';?>
	</footer>
</body>
</html>
<?php 
// закрываем подключение 
$mysqli->close();
?>