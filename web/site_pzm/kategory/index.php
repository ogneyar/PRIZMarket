<?php
// здесь открывается mysqli и подключаются переменные
include_once '../site_files/functions.php';

$количество_лотов = 10;
$категория = "";
if (isset($_POST['kategory'])) $категория = $_POST['kategory'];
if (isset($_GET['kategory'])) $категория = $_GET['kategory'];

if (isset($_POST['last_lot'])) $сколь_уже_показано = $_POST['last_lot'];
if (isset($_GET['last_lot'])) $сколь_уже_показано = $_GET['last_lot'];

if (isset($_POST['dalee']) || isset($_GET['dalee'])) $сколь_уже_показано = $сколь_уже_показано + $количество_лотов;
if (isset($_POST['nazad']) || isset($_GET['nazad'])) $сколь_уже_показано = $сколь_уже_показано - $количество_лотов;
?>
<!DOCTYPE html>
<!-- <html xmlns="http://www.w3.org/1999/xhtml"> -->
<html lang="ru">
<head>
	<meta charset="utf-8" />
	<title>Категории PRIZMarket!</title>
	<?php include_once '../site_files/head.php';?>
	
	<style type="text/css">
		@media (min-width: 700px) {
			nav a:nth-child(3), nav#fixed a:nth-child(3) {
			border-bottom: 5px solid rgb(255,235,59);
		}} 
	</style>
	
</head>
<body>
	<header>
		<?php include_once '../site_files/header.php';?>
	</header>
	<div id="lk_menu">
		<?php include_once '../lk/index-lk_menu.php';?>		
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
			if ($категория) {
				include_once 'index-output_kategory.php';
			}else include_once 'index-leftCol.php';
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
// закрывается подключение 
$mysqli->close();
?>