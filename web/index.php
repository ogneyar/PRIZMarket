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
		<a href="/">Главная</a>
		<a href="/site_pzm/podrobnosti/index.php">Подробности</a>
		<a href="<?=$ссыль_на_саппорт_бота?>" target="_blank">Саппорт</a>
		<a href="" onclick="alert('Эта функция ещё не подключена!')">О нас</a>
<!--	<a href="">Разное</a> -->
	</nav>
	<div id="slideMenu">Моё детище, а не просто сайт!</div>
	<div id="wrapper">
		<div id="leftCol">		
			<?
			foreach($лот as $публикация) {
				echo $публикация;
			}			
			?>			
		</div>
		<div id="rightCol">
			<div class="banner">
				<input type="text" placeholder="Поиск" id="search"/>
			</div>
			<div class="banner">
				<span>Стоит посмотреть:</span>
				<iframe src="https://youtu.be/7-wxMhp99N8" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="banner">
				<span>Поддержать проект:</span>
				<img src="site_pzm/img/WM_sps.png" id="wm" alt="Сказать спасибо" title="Сказать спасибо"/>
			</div>
		</div>
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
