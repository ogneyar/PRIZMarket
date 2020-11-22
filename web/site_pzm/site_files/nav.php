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

		<div id="fon_load"></div>

	</div> 


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


			$("#fon").click (function (){
				console.log("нажал");
				// $("#fon").visibility = 'hidden';
				// $("#fon").background = '#000';

				// $("#fon").toggle();
			});
		});
	
	</script>