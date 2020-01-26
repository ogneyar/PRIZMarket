<?
// Подключаем библиотеку с классом Bot
include_once 'myBotApi/Bot.php';
// Подключаем библиотеку с глобальными переменными
include_once 'a_conect.php';
exit('ok');
$token = $tokenInfo;

// Создаем объект бота
$bot = new Bot($token);

$id_bota = strstr($token, ':', true);	

$table_users = 'info_users';

// Группа администрирования бота (Админка)
$admin_group = $admin_group_Info;

// Подключение БД
$mysqli = new mysqli($host, $username, $password, $dbname);

// проверка подключения 
if (mysqli_connect_errno()) {
	$bot->sendMessage($master, 'Чёт не выходит подключиться к MySQL');	
	exit('ok');
}else { 	

	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ФУНКЦИЙ
	include 'BiblaInfo/Functions.php';	
	
	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ПЕРЕМЕННЫХ
	include 'myBotApi/Variables.php';
	
	// Обработчик исключений
	set_exception_handler('exception_handler');
	
	//$text = str_replace ("@TesterBotoffBot", "", $text);	
	
	//$this_admin = _this_admin();
	
	// Если пришла ссылка типа t.me//..?start=123456789
	if (strpos($text, "/start ")!==false) $text = str_replace ("/start ", "", $text);
	
	if ($text == "/start"||$text == "s"||$text == "S"||$text == "с"||$text == "С"||$text == "c"||$text == "C"||$text == "Старт"||$text == "старт") {
		if ($chat_type=='private') {
			_start_InfoBota();  			
		}	
	}
	
	if ($data['callback_query']) {
	
		include_once 'BiblaInfo/Callback_query.php';
	
	// если пришло сообщение MESSAGE подключается необходимый файл
	}elseif ($data['message']) {
		
		//-----------------------------
		// это команды бота для мастера
		if ($text){
			$number = stripos($text, '%');
			if ($number!==false&&$number == '0') {
				if ($chat_id==$master) {
					$text = substr($text, 1);
					include_once 'BiblaInfo/Commands.php';
					exit('ok');
				}
			}
		}
		//-----------------------------
		
		include_once 'BiblaInfo/Message.php';		
		
	}elseif ($data['channel_post']) {
		
		include_once 'BiblaInfo/Channel_post.php';
		
	}
	
}

// закрываем подключение 
$mysqli->close();		


exit('ok'); //Обязательно возвращаем "ok", чтобы телеграмм не подумал, что запрос не дошёл
?>
