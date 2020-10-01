<?php
include_once '../vendor/autoload.php';	
include_once 'a_conect.php';

if ($_SERVER['HTTPS']) {
    echo "HTTPS: ".$_SERVER['HTTPS'];
} else {
    echo "HTTP";
} 

$количество_лотов = 10;

include_once 'site_pzm/pzmarket.php';

?>
<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title>PRIZMarket!</title>
	<meta name="description" content="Сайт для рекламы товаров/услуг за криптовалюту PRIZM" />
	<meta name="keywords" content="PRIZM, криптовалюта, товары, услуги, куплю, продам, безоплатно, бесплатно" />
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
	<div id="lk_menu">
		<?include_once 'site_pzm/lk/index-lk_menu.php';?>		
	</div>
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