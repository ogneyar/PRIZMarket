<?php 
include_once '../../a_conect.php';
// Подключаем библиотеку с классом Bot
include_once '../../myBotApi/Bot.php';
//exit('ok');

// $token = $tokenSite;
// $bot = new Bot($token);
// $id_bota = strstr($token, ':', true);	
// include '../../myBotApi/Variables.php';
// $admin_group = $admin_group_Site;

$mysqli = new mysqli($host, $username, $password, $dbname);
// проверка подключения 
if (mysqli_connect_errno()) {
	throw new Exception('Чёт не выходит подключиться к MySQL');	
	exit('ok');
}
// Обработчик исключений
set_exception_handler('exception_handler');

$запрос = "SELECT login, password, token FROM `site_users`"; 
$результат = $mysqli->query($запрос);
if ($результат)	{
	$количество = $результат->num_rows;	
	if($количество > 0) {
		$результМассив = $результат->fetch_all(MYSQLI_ASSOC);			
	}else {
		$результМассив = null;
	}
	$json = json_encode($результМассив);
}else throw new Exception('Не смог проверить таблицу `site_users`.. (работа сайта)');	

// закрываем подключение 
$mysqli->close();

// при возникновении исключения вызывается эта функция
function exception_handler($exception) {
	// global $mysqli, $bot, $admin_group;
	// $bot->sendMessage($admin_group, "Ошибка! ".$exception->getCode()." ".$exception->getMessage());	  
	// $mysqli->close();		
	exit('ok');  	
}

?>
<!DOCTYPE html>
<!-- <html xmlns="http://www.w3.org/1999/xhtml"> -->
 <html lang="ru">
<head>
	<meta charset="utf-8" />	
	<title>Вход в PRIZMarket!</title>
	<?php include_once '../site_files/head.php';?>	
</head>
<body>
	<header>
		<?php include_once '../site_files/header.php';?>
	</header>
	<div id="lk_menu">
		<?php include_once '../lk/index-lk_menu.php';?>		
	</div>
	<nav>
		<?php include_once '../site_files/nav.php';?>
	</nav>
	<div id="slideMenu">Моё детище, а не просто сайт!</div>
	<div id="wrapper">
		<div id="TopCol">		
			<?php include_once '../site_files/wrapper-topCol.php';?>
		</div>
		<div id="leftCol">		
			<?php include_once 'index-leftCol.php';?>
		</div>
		<div id="rightCol">
			<?php include_once '../site_files/wrapper-rightCol.php';?>
		</div>
	</div>
	<footer>
		<?php include_once '../site_files/footer.php';?>
	</footer>

	
	<script>
		$(document).ready (function (){			
			$("#submit").click (function (){
				$('#warning').html (' ' + "<br>");
				$('#warning').show ();
				var login = $("#login").val ();
				var password = $("#password").val ();
				var fail = "";
				var veren_login = false;
				var veren_pass = false;
				var stroka = <?=$json; ?>;	
				var token = "";
				
				if (login.length < 1) fail = "Вы не ввели логин";				
				else if (login.length < 4) fail = "Логин не бывает менее 4х символов";
				else if (password.length < 1) fail = "Вы не ввели пароль";
				else if (password.length < 4) fail = "Пароль не бывает менее 4х символов";
				
				for (var key in stroka) {
					var str = stroka[key];
					for (var k in str) {
						if (k == 'login') {
							if (login == str[k]) {
								veren_login = true;
								if (str['password'] == password) {
									veren_pass = true;
									token = str['token'];
								}
							}
						}
					}
				}
				
				if (!veren_login) fail = "Не верно введён логин";
				else if (!veren_pass) fail = "Не верно введён пароль";
				
				if (fail != "") {
					$('#warning').html (fail  + "<br>");
					$('#warning').show ();
					return false;
				}else {
					$('#vhod').html ("<br><h4>Ожидайте..</h4>");
					$('#vhod').show ();
				}
				
				$.ajax ({
					url: '/site_pzm/vhod/index-vhod.php',
					type: 'POST',
					cache: false,
					data: {'login': login, 'token': token},
					dataType: 'html',
					success: function (data) {
						$('#vhod').html ("<br><h4>" + data + "</h4>");
						$('#vhod').show ();		
						setTimeout(function(){
							location.reload();
						}, 500);
					}
				});
				
			});
		});
	</script>


</body>
</html>
