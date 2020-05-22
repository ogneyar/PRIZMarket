<?php
// здесь открывается mysqli и подключаются переменные
include_once '../site_files/functions.php';
$категория = "";
if ($_POST['kategory']) $категория = $_POST['kategory'];
if ($_GET['kategory']) $категория = $_GET['kategory'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title>Категории PRIZMarket!</title>
	<?include_once '../site_files/head.php';?>
	
	<style type="text/css">
		@media (min-width: 700px) {
			nav a:nth-child(3), nav#fixed a:nth-child(3) {
			border-top: 5px solid rgba(255,235,59);
		}} 
	</style>
	
</head>
<body>
	<header>
		<?include_once '../site_files/header.php';?>
	</header>
	<div id="lk_menu">
		<?include_once '../lk/index-lk_menu.php';?>		
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
			<?
			if ($категория) {
				include_once 'index-output_kategory.php';
			}else include_once 'index-leftCol.php';
			?>
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
// закрывается подключение 
$mysqli->close();
?>