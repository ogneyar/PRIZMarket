<?
// Подключаем библиотеку с классом Bot
include_once 'BiblaZakaz/Bot.php';
// Подключаем библиотеку с глобальными переменными
include_once 'a_conect.php';
//exit('ok');
$token = $tokenZakaz;

// Создаем объект бота
$bot = new Bot($token);

$id_bota = strstr($token, ':', true);	

$table_message = 'zakaz_message';

// Группа администрирования бота (Админка)
$admin_group = $admin_group_Zakaz;

// Подключение БД
$mysqli = new mysqli($host, $username, $password, $dbname);

// проверка подключения 
if (mysqli_connect_errno()) {
	$bot->sendMessage($master, 'Чёт не выходит подключиться к MySQL');	
	exit('ok');
}else { 	

	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ФУНКЦИЙ
	include 'BiblaZakaz/Functions.php';	
	
	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ПЕРЕМЕННЫХ
	include 'BiblaZakaz/Variables.php';
	
	// Обработчик исключений
	set_exception_handler('exception_handler');
	
	//$text = str_replace ("@TesterBotoffBot", "", $text);	
	
	//$this_admin = _this_admin();
	
	if ($text == "/start"||$text == "s"||$text == "S"||$text == "с"||$text == "С"||$text == "c"||$text == "C"||$text == "Старт"||$text == "старт") {
		if ($chat_type=='private') {
			_start_Zakaz_bota();  			
		}	
	}
	
	if ($data['callback_query']) {
	
		include_once 'BiblaZakaz/Callback_query.php';
	
	// если пришло сообщение MESSAGE подключается необходимый файл
	}elseif ($data['message']) {
		
		//-----------------------------
		// это команды бота для мастера
		if ($text){
			$number = stripos($text, '%');
			if ($number!==false&&$number == '0') {
				if ($chat_id==$master) {
					$text = substr($text, 1);
					include_once 'BiblaZakaz/Commands.php';
					exit('ok');
				}
			}
		}
		//-----------------------------
				
		include_once 'BiblaZakaz/Message.php';		
		
	}
}

// закрываем подключение 
$mysqli->close();		


exit('ok'); //Обязательно возвращаем "ok", чтобы телеграмм не подумал, что запрос не дошёл
?>
