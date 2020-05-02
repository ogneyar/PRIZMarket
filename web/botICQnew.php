<?
// Подключаем библиотеку с классом Bot
include_once 'myBotApi/Bot.php';
// Подключаем библиотеку с глобальными переменными
include_once 'a_conect.php';
//exit('ok');
$token = $tokenICQnew;
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


<?
// Подключаем библиотеку с классом Bot
include_once 'icqNew-BotApi-php/Bot.php';

$ICQtoken = "001.2839288818.3919878723:752122979";

//exit('ok');

// Создаем объект бота
$bot_icq = new Bot($token_icq);

$id_icq_bota = substr(strstr($token_icq, ':'), 1);	

$eventId = 0;

$bot_icq->sendText("@Ogneyar_", "Цикл начат.");

do {	
	$события = $bot_icq->getEvents($eventId,20);

	if ($события == []) {
		$eventId = 0;
		//break;
	}else {
	
		foreach($события as $event) {
			$eventId = $event['eventId'];		
			$payload = $event['payload'];
				$chat = $payload['chat'];
					$chatId = $chat['chatId'];
					$chatType = $chat['type'];
				$from = $payload['from'];
					$firstName = $from['firstName'];
					$nick = $from['nick'];
					$userId = $from['userId'];
				$msgId = $payload['msgId'];
				$text = $payload['text'];
				$timestamp = $payload['timestamp'];
			$type = $event['type'];
		}	
		
		echo "Последнее событие: ".$eventId."<br><br>";
		
		if ($text=='ё') {
			$bot_icq->sendText($chatId, "клмн");
		}elseif ($text=='/start') {
			$реплика = "Здравствуй ".$firstName."\n\nПопробуй команду /help";
			$bot_icq->sendText($chatId, $реплика);
		}elseif ($text=='/help') {
			if ($nick == 'Ogneyar_') {
				$реплика = "Список понимаемых мною команд:\n\nё\nПривет\nКак дела?\nеее\nуфь\n\n/exit";
			}else $реплика = "Список понимаемых мною команд:\n\nё\nПривет\nКак дела?\nеее\nуфь";
			$bot_icq->sendText($chatId, $реплика);
		}elseif ($text=='/exit') {
			if ($nick == 'Ogneyar_') {
				$события = $bot_icq->getEvents($eventId,0);
				break;
			}
		}elseif ($text=='Привет') {
			$реплика = "Сам ты привет. И брат твой привет. И сестра твоя привет.";
			$bot_icq->sendText($chatId, $реплика);
		}elseif ($text=='Как дела?') {
			$реплика = "Дааа норм чо, а #сам_чо_как?";
			$bot_icq->sendText($chatId, $реплика);
		}elseif ($text=='еее') {
			$реплика = "Так держать хозяин!";
			$bot_icq->sendText($chatId, $реплика);
		}elseif ($text=='уфь') {
			$реплика = "Эт ты на каком языке? Уууфь, нет такой буквы в алфавите!";
			$bot_icq->sendText($chatId, $реплика);
		}elseif ($text) $bot_icq->sendText($chatId, "я не понимаю(");
	
	}

}while ($eventId>=0);

echo "Цикл окончен. <br><br>";
$bot_icq->sendText("@Ogneyar_", "Цикл окончен.");

echo "<pre>"; print_r($события); echo "</pre><br><br>";

exit('ok');

?>