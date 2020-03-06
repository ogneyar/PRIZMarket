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
		<?include_once 'site_pzm/site_files/div-wrapper.html';?>
	</div>
	<footer>
		<div id="rights">
			&copy; PRIZMarket <?=date('Y')?>
		</div>
		<div id="social">			
			<a href="https://www.instagram.com/prizm_market_inst" title="Инстаграм" target="_blank"><img src="site_pzm/img/social/instagram.png" alt="Инстаграм PRIZMarket" /></a>
			<a href="https://vk.com/prizmarket_vk" title="Группа Вконтакте" target="_blank"><img src="site_pzm/img/social/vkontakte.png" alt="Вконтакте PRIZMarket" /></a>
		</div>
	</footer>
</body>
</html>
