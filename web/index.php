<?php
if ($_SERVER['HTTP_HOST']=='www.prizmarket.ru') header('Location: https://prizmarket.ru');
if ($_SERVER['HTTP_HOST']=='www.prizmarket.online') header('Location: https://prizmarket.online');

$имя_сервера = $_SERVER['SERVER_NAME'];
	
include_once '../vendor/autoload.php';	
include_once 'a_conect.php';

$количество_лотов = 10;

include_once 'site_pzm/pzmarket.php';

?>
<!DOCTYPE html>

<html lang="ru">
<head>
	<meta charset="utf-8" />
	<title>PRIZMarket!</title>
	<meta name="description" content="Сайт для рекламы товаров/услуг за криптовалюту PRIZM" />
	<meta name="keywords" content="PRIZM, криптовалюта, товары, услуги, куплю, продам, безоплатно, бесплатно" />

	<meta name="yandex-verification" content="ecfd40d0765ac403" />

	<?php include_once 'site_pzm/site_files/head.php';?>
	<style type="text/css">
		@media (min-width: 700px) {
		nav a:first-child, nav#fixed a:first-child {
			border-bottom: 5px solid rgb(255,235,59);
		}} 
	</style>
</head>
<body>
	<header>
		<?php include_once 'site_pzm/site_files/header.php';?>
	</header>
	<div id="lk_menu">
		<?php include_once 'site_pzm/lk/index-lk_menu.php';?>		
	</div>
	<nav>
		<?php include_once 'site_pzm/site_files/nav.php';?>
	</nav>
	<div id="slideMenu">Моё)</div>
	
	<div id="wrapper">
		<div id="TopCol">		
			<?php echo $имя_сервера; include_once 'site_pzm/site_files/wrapper-topCol.php'; ?>
		</div>
		<div id="leftCol">		
			<?php include_once 'site_pzm/site_files/wrapper-leftCol.php';?>
		</div>
		<div id="rightCol">
			<?php include_once 'site_pzm/site_files/wrapper-rightCol.php';?>
		</div>
	</div>
	<footer>
		<?php include_once 'site_pzm/site_files/footer.php';?>
	</footer>
</body>
</html>
