<?php
include_once '../vendor/autoload.php';	
include_once 'a_conect.php';
include_once 'site_pzm/pzmarket.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />	
	<title>PRIZMarket Ваш рынок!</title>
	<meta name="description" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="all,index,follow" />
	<meta name="distribution" content="global" />
	
	<!-- Adopt website to current screen -->
	<meta name="viewport" content="user-scalable=yes, width=device-width, initial-scale=1.0, maximum-scale=1.0">
	
	<link rel="stylesheet" href="site_pzm/css/style.css">
	
	<!-- Here we add libs for jQuery, Ajax... -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	
	<script type="text/javascript">
		if(screen.width > 800) { // Animate navigation
			$(document).ready(function() {
			// функцию скролла привязать к окну браузера
				$(window).scroll(function(){
					var distanceTop = $('#slideMenu').offset().top;
					if ($(window).scrollTop() >= distanceTop)
						$ ('nav').attr ("id", "fixed");
					else //if ($(window).scrollTop() < distanceTop)
						$ ('nav').attr ("id", "nav");
				});
			});
		}
	</script>
</head>
<body>
	<header>
		<a href="/" id="logo">
			<span>PRIZM</span>arket 
			<span>Ваш</span> рынок!
		</a>
		<span id="contact">
			<a href="">Реклама</a>
			<a href="">Контакты</a>
		</span>
	</header>
	<nav>
		<a href="/">Главная</a>
		<a href="">Подробности</a>
		<a href="">Медиа</a>
		<a href="">Саппорт</a>
		<a href="">Разное</a>
	</nav>
	<div id="slideMenu">Уроки по программированию!</div>
	<div id="wrapper">
		<div id="leftCol">
			<article>
				<a href="" title=""><img src="<?=$ссыль_на_фото[0]?>" alt="" title=""/></a>				
				<?=$текст_лота[0]?>
				<p><a href="" title="">Подробности</a><span>2 марта 2020 в 22:18</span></p>
			</article>
			<article>
				<a href="" title=""><img src="<?=$ссыль_на_фото[1]?>" alt="" title=""/></a>				
				<?=$текст_лота[1]?>
				<p><a href="" title="">Читать далее</a><span>2 марта 2020 в 22:22</span></p>
			</article>
			<article>
				<a href="" title=""><img src="<?=$ссыль_на_фото[2]?>" alt="" title=""/></a>				
				<?=$текст_лота[2]?>
				<p><a href="" title="">Читать далее</a><span>30 ноября 2015 в 1:58</span></p>
			</article>			
		</div>
		<div id="rightCol">
			<div class="banner">
				<input type="text" placeholder="Поиск" id="search"/>
			</div>
			<div class="banner">
				<span>Стоит посмотреть:</span>
				<iframe src="https://youtu.be/1mMzEIjz9uY" frameborder="0" allowfullscreen></iframe>
			</div>
			<div class="banner">
				<span>Поддержать проект:</span>
				<img src="site_pzm/img/WM_sps.png" id="wm" alt="Сказать спасибо" title="Сказать спасибо"/>
			</div>
		</div>
	</div>
	<footer>
		<div id="rights">
			Все права защищены &copy; <?=date('Y')?>
		</div>
		<div id="social">
			<a href="" title="Google+"><img src="site_pzm/img/social/Google+.png" alt="Google+" /></a>
			<a href="" title="Группа FaceBook"><img src="site_pzm/img/social/facebook.png" alt="Группа FaceBook" /></a>
			<a href="" title="Группа Вконтакте"><img src="site_pzm/img/social/vkontakte.png" alt="Группа Вконтакте" /></a>
		</div>
	</footer>
</body>
</html>
