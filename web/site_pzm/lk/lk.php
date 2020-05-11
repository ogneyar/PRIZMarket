<?
$вывод = "";
if ($_COOKIE['login']) $вывод = $_COOKIE['login'];

$login_json = json_encode($вывод);
?>
<script>
	$(document).ready (function (){		

                var login = <?=$login_json;?>;
                if (login != "") {
                        $('#contact').hide ();
		
		        $('#client').html (login);
	        	$('#client').show ();
                }else {
					$('.lk_topmenu').hide ();
				}
	});
</script>

<span id="contact">
	<a href="/site_pzm/vhod/index.php">Вход</a>
	<a href="/site_pzm/registraciya/index.php?st=zero">Регистрация</a>
</span>

<ul class="lk_topmenu">
	<li id="lk_mini-menu">
		<a href="#"><label id="client"></label></a>
			
		<ul class="lk_submenu">	
			<!--<li><a href="/site_pzm/lk/index.php">Личный кабинет</a></li>-->
			<li><a href="/site_pzm/lk/sozdanie.php">Создать заявку</a></li>
			<li><a href="/site_pzm/lk/zayavki.php">Ваши заявки</a></li>
			<!--<li><a href="/site_pzm/lk/test.php">Тест</a></li>-->
			<li><a href="/site_pzm/lk/exit.php">Выход</a></li>			
		</ul>
			
	</li>
</ul>