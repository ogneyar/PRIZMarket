<!-- <div class="line-menu"> 
<a href="/">Главная</a>
<a href="/site_pzm/podrobnosti/index.php?podrobnosti=st">Подробно</a>
<a href="/site_pzm/kategory/index.php">Категории</a>
<a href="/site_pzm/support/index.php">ТехПоддержка</a>
<a href="/site_pzm/o_prizmarket/index.php">О нас</a>
</div>
<ul class="topmenu">
	<li class="topmenu_li"><a href="#"><i class="fa fa-bars fa-lg" aria-hidden="true"></i></a>
		<ul class="submenu">	
			<li><a href="/">Главная</a></li>
			<li><a href="/site_pzm/podrobnosti/index.php?podrobnosti=st">Подробно</a></li>
			<li><a href="/site_pzm/kategory/index.php">Категории</a></li>
			<li><a href="/site_pzm/support/index.php">ТехПоддержка</a></li>
			<li><a href="/site_pzm/o_prizmarket/index.php">О_нас</a></li>
		</ul>
	</li>
</ul> -->


	<div class="line-menu">
		<a href="/">Главная</a>
		<a href="/site_pzm/podrobnosti/index.php?podrobnosti=st">Подробно</a>
		<a href="/site_pzm/kategory/index.php">Категории</a>
		<a href="/site_pzm/support/index.php">ТехПоддержка</a>
		<a href="/site_pzm/o_prizmarket/index.php">О нас</a>
	</div>	
	<div class="topmenu">		
		<input type="checkbox" id="check">
		<label for="check">			
			<i class="fa fa-bars fa-lg" aria-hidden="true" id="btn"></i>
			<i class="fa fa-times fa-lg" aria-hidden="true" id="cancel"></i>

			<i id="fon"></i>
		</label>	
		<div class="sidebar">
			<header>&nbsp;М&nbsp;Е&nbsp;Н&nbsp;Ю&nbsp;</header>
			<ul>	
				<li><a href="/">Главная</a></li>
				<li><a href="/site_pzm/podrobnosti/index.php?podrobnosti=st">Подробно</a></li>
				<li><a href="/site_pzm/kategory/index.php">Категории</a></li>
				<li><a href="/site_pzm/support/index.php">ТехПоддержка</a></li>
				<li><a href="/site_pzm/o_prizmarket/index.php">О нас</a></li>
			</ul>
		</div>
	</div> 
	
	<!-- <div id="fon_load"></div> -->
	
	<!--  Показ изображения во время загрузки страницы  -->
	<section id="section">
		<div class="box">
			<div class="loader">		    
				<span style="--i:1;"></span>
				<span style="--i:2;"></span>
				<span style="--i:3;"></span>
				<span style="--i:4;"></span>
				<span style="--i:5;"></span>
				<span style="--i:6;"></span>
				<span style="--i:7;"></span>
				<span style="--i:8;"></span>
				<span style="--i:9;"></span>
				<span style="--i:10;"></span>
				<span style="--i:11;"></span>
				<span style="--i:12;"></span>
				<span style="--i:13;"></span>
				<span style="--i:14;"></span>
				<span style="--i:15;"></span>
				<span style="--i:16;"></span>
				<span style="--i:17;"></span>
				<span style="--i:18;"></span>
				<span style="--i:19;"></span>
				<span style="--i:20;"></span>	
			</div>
		</div>
	</section>


	<script type="text/javascript">
		
		$(document).ready(function() {
		// функцию скролла привязать к окну браузера
			$(window).scroll(function(){
				var distanceTop = $('#slideMenu').offset().top;
				if ($(window).scrollTop() >= distanceTop)
					$ ('nav').attr ("id", "fixed");
				else //if ($(window).scrollTop() < distanceTop)
					$ ('nav').attr ("id", "menu");
			});
		});
	
	</script>