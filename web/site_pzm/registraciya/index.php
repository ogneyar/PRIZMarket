<?php
//include_once '../../../vendor/autoload.php';	
include_once '../../a_conect.php';
// Подключаем библиотеку с классом Bot
include_once '../../myBotApi/Bot.php';
//exit('ok');
$token = $tokenSite;
// Создаем объект бота
$bot = new Bot($token);
$id_bota = strstr($token, ':', true);	
// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ПЕРЕМЕННЫХ
include '../../myBotApi/Variables.php';
$admin_group = $admin_group_Site;

$mysqli = new mysqli($host, $username, $password, $dbname);
// проверка подключения 
if (mysqli_connect_errno()) {
	throw new Exception('Чёт не выходит подключиться к MySQL');	
	exit('ok');
}
// Обработчик исключений
set_exception_handler('exception_handler');

$запрос = "SELECT login FROM `site_users`"; 
$результат = $mysqli->query($запрос);
if ($результат)	{
	$количество = $результат->num_rows;	
	if($количество > 0) {
		$результМассив = $результат->fetch_all(MYSQLI_ASSOC);	
		$json = json_encode($результМассив);
		$bot->sendMessage($admin_group, $json);
	}else {
		$результМассив = null;
		$json = null;
	}
}else throw new Exception('Не смог проверить таблицу `site_users`.. (работа сайта)');	

if (($_GET['registration'] == '1')&&($результМассив)) {	
	foreach ($результМассив as $строка) {
		if ($строка['login'] == $_GET['login']) {
			$логин = $строка['login'];
			$запрос = "UPDATE `site_users` SET podtverjdenie='true' WHERE login='{$логин}'"; 
			$результат = $mysqli->query($запрос);
			if (!$результат) throw new Exception('Не смог изменить таблицу `site_users`.. (работа сайта)');	
		}
	}	
}

$client  = @$_SERVER['HTTP_CLIENT_IP'];
$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
$remote  = @$_SERVER['REMOTE_ADDR']; 
if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
else $ip = $remote;
if ($_GET['st'] == 'zero') $bot->sendMessage($admin_group, "Кто-то желает зарегаться на сайте!\nего IP: {$ip}");


// закрываем подключение 
$mysqli->close();

// при возникновении исключения вызывается эта функция
function exception_handler($exception) {
	global $mysqli, $bot, $admin_group;
	$bot->sendMessage($admin_group, "Ошибка! ".$exception->getCode()." ".$exception->getMessage());	  
	$mysqli->close();		
	exit('ok');  	
}
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
				$('#warning').html (' ' + "<br>");
				$('#warning').show ();
				var login = $("#login").val ();
				var password = $("#password").val ();
				var password2 = $("#password2").val ();
				var email = $("#email").val ();
				var fail = "";
				var stroka = <?=$json; ?>;			
				
				for (var key in stroka) {
					fail = fail + " " + key;
					if (login == key) fail = "Такой логин уже существует";
				}
				fail = fail + " " + login;
				
				<!--if (login.length < 4) fail = "Логин не менее 4х символов";				else if (password.length < 4) fail = "Пароль не менее 4х символов";				else if (password != password2) fail = "Не верен повторно введённый пароль";				else if (email.split ('@').length - 1 == 0 || email.split ('.').length - 1 == 0) 					fail = "Вы ввели некорректный email";
				-->
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
					success: function (data) {
						$('#registr').html ("<br><p>" + data + "</p><br>");
						$('#registr').show ();						
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
			<?
			if ($_GET['registration'] == '1') {
				include_once 'wrapper-leftCol-podtverjdenie.php';
			}else {
				include_once 'wrapper-leftCol-registraciya.php';
			}
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
