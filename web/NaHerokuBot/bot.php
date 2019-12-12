<?php 
require_once('../../vendor/autoload.php');

//TOKEN NaHerokuBota
$token='999999999:ZZZZZZZZZZZZZZZZZZZZZZZZZZZZZ-ZZZZZ';

$tg = new \TelegramBot\Api\BotApi($token);

//include_once "session.madeline";

//$MP = \danog\MadelineProto\Serialization::deserialize('session.madeline');
//$MP = new \danog\MadelineProto\API('session.madeline');
//$MP->async(true);
//$MP->start();

// Группа администрирования бота (Админка)
$admin_group = '-1001311775764';
// Группа для тестирования бота (Тестрование Ботов)
$admin_group_test = '-362469306'; 
// Мастер это Я
$master='351009636';

// ФЛАГ ДЛЯ ВКЛЮЧЕНИЯ РЕЖИМА ОТЛАДКИ БОТА
$OtladkaBota = 'да';

include_once '../a_conect.php';

$mysqli = new mysqli($host, $username, $password, $dbname);

// проверка подключения 
if (mysqli_connect_errno()) {
	$tg->sendMessage($master, 'Чёт не выходит подключиться к MySQL');	
	exit('ok');
}else { 
	
	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ПЕРЕМЕННЫХ
	include 'bot_02_varia.php';
	
	$text = str_replace ("@NaHerokuBot", "", $text);

	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ФУНКЦИЙ
	include 'bot_03_func.php';
	
	$this_admin = _this_admin();
	
	if ($text == "/start"||$text == "s"||$text == "S"||$text == "с"||$text == "С"||$text == "c"||$text == "C") {
		if ($chat_type=='private') {
			_start_PZMgarant_bota($this_admin);  //БЕЗОПАСНЫЕ СДЕЛКИ
		}	
	}
	
	// ПОДКЛЮЧЕНИЕ ОСНОВНОГО МОДУЛЯ
	include_once 'bot_01_head.php';	
	
}

// закрываем подключение 
$mysqli->close();		

exit('ok'); //Обязательно возвращаем "ok", чтобы телеграмм не подумал, что запрос не дошёл
?>
