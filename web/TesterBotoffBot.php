<?php 
include_once '../vendor/autoload.php';	
include_once 'a_conect.php';

//exit('ok');

$tg = new \TelegramBot\Api\BotApi($tokenGARANT);

$id_bota = '1066944801';

// Группа администрирования бота (Админка)
$admin_group = '-1001306245472';
// Группа для тестирования бота (Тестрование Ботов)
$admin_group_test = '-362469306'; 
// Мастер это Я
$master='351009636';
$testerbotoff = '1038937592';
$channel='-1001368618561';  // Канал ТестерБотофф

// ФЛАГ ДЛЯ ВКЛЮЧЕНИЯ РЕЖИМА ОТЛАДКИ БОТА
$OtladkaBota = 'да';

$mysqli = new mysqli($host, $username, $password, $dbname);

// проверка подключения 
if (mysqli_connect_errno()) {
	$tg->sendMessage($master, 'Чёт не выходит подключиться к MySQL');	
	exit('ok');
}else { 	
	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ПЕРЕМЕННЫХ
	include 'GarantBibla/01_variables.php';
	
	$text = str_replace ("@TesterBotoffBot", "", $text);

	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ФУНКЦИЙ
	include 'GarantBibla/02_functions.php';
	
	$this_admin = _this_admin();
	
	if ($text == "/start"||$text == "s"||$text == "S"||$text == "с"||$text == "С"||$text == "c"||$text == "C"||$text == "Старт"||$text == "старт") {
		if ($chat_type=='private') {
			_start_PZMgarant_bota();  //БЕЗОПАСНЫЕ СДЕЛКИ			
		}	
	}
	
	// ПОДКЛЮЧЕНИЕ ОСНОВНОГО МОДУЛЯ
	include_once 'GarantBibla/03_header_bot.php';		
}

// закрываем подключение 
$mysqli->close();		

exit('ok'); //Обязательно возвращаем "ok", чтобы телеграмм не подумал, что запрос не дошёл
?>