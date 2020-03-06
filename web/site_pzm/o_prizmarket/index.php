<?php
//include_once '../vendor/autoload.php';	
include_once 'a_conect.php';
include_once 'site_pzm/pzmarket.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />	
	<title>PRIZMarket!</title>
	<?include_once 'site_pzm/site_files/head.html';?>
</head>
<body>
	<header>
		<?include_once 'site_pzm/site_files/header.html';?>
	</header>
	<nav>
		<?include_once 'site_pzm/site_files/nav.html';?>
	</nav>
	<div id="slideMenu">Моё детище, а не просто сайт!</div>
	<div id="wrapper">
		<div id="leftCol">		
			<?include_once 'site_pzm/site_files/div-wrapper-leftCol-o_prizmarket.php';?>
		</div>
		<div id="rightCol">
			<?include_once 'site_pzm/site_files/div-wrapper-rightCol.html';?>
		</div>
	</div>
	<footer>
		<?include_once 'site_pzm/site_files/footer.html';?>
	</footer>
</body>
</html>