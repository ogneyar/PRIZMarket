<?php
include_once '../../a_conect.php';

if (!isset($_COOKIE['login'])) header('Location: /site_pzm/vhod/index.php');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8" />
	<title>Личный кабинет PRIZMarket!</title>
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
			<?php include_once 'index-leftCol.php';?>
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
