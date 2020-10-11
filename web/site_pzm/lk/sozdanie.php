<?php
if (!$_COOKIE['login']) header('Location: /site_pzm/vhod/index.php');
if (!$_COOKIE['token']) header('Location: /site_pzm/vhod/index.php');
$логин = $_COOKIE['login'];
$токен = $_COOKIE['token'];

include_once "../site_files/functions.php";
// Открыл базу данных, в конце обязательно надо закрыть
include_once '../../a_mysqli.php';

if (!isset($_GET['url'])) {	
	// сходятся ли логин и токен
	$всё_норм = _сравни_токен_и_логин($логин, $токен);	
	
	$подтверждён = _подтверждён_ли_клиент($логин);
	if ($подтверждён) $давно = _последняя_публикация_на_сайте($логин);
	else $давно = false;
	
}elseif (isset($_GET['login'])) {
	$всё_норм = _сравни_токен_и_логин($_GET['login'], $токен);
}/*elseif (isset($_POST['login'])) {
	$всё_норм = _сравни_токен_и_логин($_POST['login'], $токен);
}*/

if (!$всё_норм) include_once 'exit.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<title>Ваши заявки на PRIZMarket!</title>
	<?include_once '../site_files/head.php';?>		
	
	<!-- <script type="text/javascript" src="sozdanie.js"></script>	-->

<script>

$(document).ready (function (){
	$("#done").click (function ( event ){
		event.stopPropagation(); // остановка всех текущих JS событий
		event.preventDefault();  // остановка дефолтного события
				
		$('#warning').html (' ' + "<br>");
		$('#warning').show ();
						
		var login = $("#login").val ();
		var hesh_pk = $("#hesh_pk").val ();
		var name = $("#name").val ();
		var link_name = $("#link_name").val ();
		var hesh_kateg = $("#hesh_kateg").val ();
		var currency = $("#currency").val ();
		var hesh_city = $("#hesh_city").val ();
		var opisanie = $("#opisanie").val ();
		var fail = "";		
		
		if (opisanie.length < 100) fail = "Описание не менее 100 символов";
		
		if (currency.length < 0) fail = "Валюта не менее 4х символов";		
		else if (hesh_city.length < 4) fail = "Хештеги не менее 4х символов";	
		else if (hesh_city.length > 3) {
			if(hesh_city.indexOf('#')+1 < 1) fail = "Нет символа '#' в хештегах";		
		}
		
		if (name.length < 3) fail = "Название не менее 3х символов";
		else if (link_name.length > 0) {
			if(link_name.indexOf('.')+1 < 1) fail = "В ссылке не указан домен '.ru' или '.com'";			
		}
		
		if (login == 'Огнеяр') fail = "";
			
		if (fail != "") {
			$('#warning').html (fail  + "<br>");
			$('#warning').show ();										
			return false;
		}else {					
			$('#lk').html ("<br><h4>Ожидайте..</h4>");
			$('#lk').show ();		
		}		
		
		$.ajax ({
			url: '/site_pzm/lk/sozdanie-save_zakaz.php',
			type: 'POST',
			cache: false,
			data: {
				'hesh_pk': hesh_pk, 
				'name': name, 
				'link_name': link_name,
				'hesh_kateg': hesh_kateg, 
				'currency': currency, 
				'hesh_city': hesh_city,
				'opisanie': opisanie
			},
			dataType: 'html',
			success: function (data) {
				$('#lk').html ("<br><h4>" + data + "</h4>");
				$('#lk').show ();						
			}
		});
		
	});
});	

</script>

	
</head>
<body>
	<header>
		<?include_once '../site_files/header.php';?>
	</header>
	<div id="lk_menu">
		<?include_once 'index-lk_menu.php';?>
	</div>
	<nav>
		<?include_once '../site_files/nav.php';?>
	</nav>
	<div id="slideMenu">Моё детище, а не просто сайт!</div>
	<div id="wrapper">
		<div id="TopCol">
			<?include_once '../site_files/wrapper-topCol.php';?>
		</div>
		<div id="leftCol">
		<?
		if (isset($_GET['url'])) {
			include_once 'sozdanie-save_photo.php';
		}else {
			if ($подтверждён) {					
				if ($давно) { 
					include_once 'sozdanie-leftCol.php';	
				}else include_once 'sozdanie-net-leftCol.php';	
			}else {
				include_once 'sozdanie-nepodtv-leftCol.php';
			}
		}
		/*elseif (isset($_POST['render_to_beget'])) {
			include_once 'sozdanie-render_to_beget.php';
		}*/
		?>
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
<?
// закрываем подключение 
$mysqli->close();
?>
