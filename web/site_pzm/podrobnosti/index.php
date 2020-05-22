<?php
//include_once '../../../vendor/autoload.php';	
//include_once '../../a_conect.php';

$количество_лотов = 10;
$категория = "";
if ($_POST['kategory']) $категория = $_POST['kategory'];
if ($_GET['kategory']) $категория = $_GET['kategory'];

if (!$категория) include_once '../pzmarket.php';

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title>Подробности PRIZMarket!</title>
	<?include_once '../site_files/head.php';?>
	
	<style type="text/css">
                @media (min-width: 700px) {
		nav a:nth-child(2), nav#fixed a:nth-child(2) {
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
			<?include_once 'index-leftCol.php';?>
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
