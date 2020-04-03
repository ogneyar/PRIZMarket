<?php 
include_once '../vendor/autoload.php';	
include_once 'a_conect.php';
//exit('ok');

$token = $tokenGARANT;
$tg = new \TelegramBot\Api\BotApi($token);

$id_bota = strstr($token, ':', true);	

// Группа администрирования бота (Админка)
$admin_group = $admin_group_garant;

// Подключение базы данных
$mysqli = new mysqli($host, $username, $password, $dbname);

// проверка подключения 
if (mysqli_connect_errno()) {
	$tg->sendMessage($master, 'Чёт не выходит подключиться к MySQL');	
	exit('ok');
}else { 	
	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ПЕРЕМЕННЫХ
	include 'BiblaGarant/01_variables.php';
	
	//$text = str_replace ("@TesterBotoffBot", "", $text);

	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ФУНКЦИЙ
	include 'BiblaGarant/02_functions.php';
	
	_проверка_БАНа('info_users', $chat_id);
	
	$this_admin = _this_admin();

        
	// Если пришла ссылка типа t.me//..?start=123456789
	if (strpos($text, "/start ")!==false) $text = str_replace ("/start ", "", $text);
	
	
	if ($text == "/start"||$text == "s"||$text == "S"||$text == "с"||$text == "С"||$text == "c"||$text == "C"||$text == "Старт"||$text == "старт") {
		if ($chat_type=='private') {
			_start_PZMgarant_bota();  //БЕЗОПАСНЫЕ СДЕЛКИ			
		}	
	}
	
	// ПОДКЛЮЧЕНИЕ ОСНОВНОГО МОДУЛЯ
	include_once 'BiblaGarant/03_header_bot.php';		
}

// закрываем подключение 
$mysqli->close();		

exit('ok'); //Обязательно возвращаем "ok", чтобы телеграмм не подумал, что запрос не дошёл
?>
