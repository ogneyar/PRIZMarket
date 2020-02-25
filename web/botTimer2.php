<?
// Подключаем библиотеку с классом Bot
include_once 'myBotApi/Bot.php';
// Подключаем библиотеку с глобальными переменными
include_once 'a_conect.php';
//exit('ok');
$token = $tokenTimer2;
// Создаем объект бота
$bot = new Bot($token);
$id_bota = strstr($token, ':', true);	
// Подключение БД
$mysqli = new mysqli($host, $username, $password, $dbname);
// проверка подключения 
if (mysqli_connect_errno()) {
	$bot->sendMessage($master, 'Чёт не выходит подключиться к MySQL');	
	exit('ok');
}else { 		 
	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ФУНКЦИЙ
	include 'BiblaTimer/Functions.php';			
	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ПЕРЕМЕННЫХ
	include 'myBotApi/Variables.php';		
	// Обработчик исключений
	set_exception_handler('exception_handler');
	// Если пришла ссылка типа t.me//..?start=123456789	
	if (strpos($text, "/start ")!==false) $text = str_replace ("/start ", "", $text);	
	if ($text == "/start"||$text == "s"||$text == "S"||$text == "с"||$text == "С"||$text == "c"||$text == "C"||$text == "Старт"||$text == "старт") {			
		if ($chat_type=='private') {				
			_старт_ТаймерБота();  							
		}				
	}
	if ($chat_type == 'private' || $chat_id == $channel_info) {			
		if ($data['callback_query']) {			
			//include_once 'BiblaTimer/Callback_query.php';						
		}elseif ($data['channel_post']) {			
			if ($text){					
				$number = stripos($text, '?');					
				if ($number!==false&&$number == '0') {					
					$text = substr($text, 1);				
					include_once 'BiblaTimer/Channel_post.php';					
					exit('ok');					
				}			
			}		
		}elseif ($data['edited_message']) {			
			//include_once 'BiblaTimer/Edit_message.php';					
		// если пришло сообщение MESSAGE подключается необходимый файл
		}elseif ($data['message']) {				
			//-----------------------------
			// это команды бота для мастера
			if ($text){					
				$number = stripos($text, '%');					
				if ($number!==false&&$number == '0') {						
					if ($chat_id==$master) {						
						$text = substr($text, 1);							
						include_once 'BiblaTimer/Commands.php';							
						exit('ok');							
					}						
				}					
			}				
			//-----------------------------						
			include_once 'BiblaTimer/Message.php';						
		}
	}	
	if ($inline_query) {	
		//include_once 'BiblaTimer/Inline_query.php';	
	}	
}
// закрываем подключение 
$mysqli->close();		
exit('ok'); //Обязательно возвращаем "ok", чтобы телеграмм не подумал, что запрос не дошёл
?>