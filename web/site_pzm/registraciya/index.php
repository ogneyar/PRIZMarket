<?php
//include_once '../../../vendor/autoload.php';	
include_once '../../a_conect.php';
// Подключаем библиотеку с классом Bot
include_once '../../myBotApi/Bot.php';
//exit('ok');
$token = $tokenMARKET;
// Создаем объект бота
$bot = new Bot($token);
$id_bota = strstr($token, ':', true);	
// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ПЕРЕМЕННЫХ
include '../../myBotApi/Variables.php';
$admin_group = $admin_group_market;
$client  = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$remote  = @$_SERVER['REMOTE_ADDR']; 
if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
else $ip = $remote;
if ($_GET['st'] == 'zero') $bot->sendMessage($admin_group, "Кто-то желает зарегаться на сайте!\nего IP: {$ip}");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />	
	<title>Регистрация на PRIZMarket!</title>
	<?include_once '../site_files/head.php';?>
	<style type="text/css"></style>
	
	<script>
		$(document).ready (function (){
			$("#done").click (function (){
				$('#warning').hide ();
				var login = $("#login").val ();
				var password = $("#password").val ();
				var password2 = $("#password2").val ();
				var email = $("#email").val ();
				var fail = "";
				if (login.length < 4) fail = "Логин не менее 4х символов";
				else if (password.length < 4) fail = "Пароль не менее 4х символов";
				else if (password != password2) fail = "Не верен повторно введённый пароль";
				else if (email.split ('@').length - 1 == 0 || email.split ('.').length - 1 == 0) 
					fail = "Вы ввели некорректный email";
				if (fail != "") {
					$('#warning').html (fail  + "<br>");
					$('#warning').show ();
					return false;
				}
				$.ajax ({
					url: '/site_pzm/registraciya/save_user.php',
					type: 'POST',
					cache: false,
					data: {'login': login, 'password': password, 'email': email},
					dataType: 'html',
					succes: function (data) {
						$('#warning').html (data  + "<br>");
						$('#warning').show ();
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
	<nav>
		<?include_once '../site_files/nav.php';?>
	</nav>
	<div id="slideMenu">Моё детище, а не просто сайт!</div>
	<div id="wrapper">
		<div id="TopCol">		
			<?include_once '../site_files/wrapper-topCol.php';?>
		</div>
		<div id="leftCol">		
			<?include_once 'wrapper-leftCol-registraciya.php';?>
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
