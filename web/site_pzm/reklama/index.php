<?php
//include_once '../../../vendor/autoload.php';	
//include_once '../../a_conect.php';
//include_once '../pzmarket.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />	
	<title>Ваша реклама на PRIZMarket!</title>
	<?include_once '../site_files/head.php';?>
	
	<style type="text/css">
		nav a:nth-child(4), nav#fixed a:nth-child(4) {
			border-top: 5px solid #6accd7;
		}
	</style>
	
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
			<?include_once '../site_files/wrapper-leftCol-reklama.php';?>
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