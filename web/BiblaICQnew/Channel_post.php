<?
$eventId = _событие();
if (!$eventId) {
	$eventId = 0;
	_событие($eventId);
}

//$bot_icq->sendText("@Ogneyar_", "Начало положено.");

$события = $bot_icq->getEvents($eventId,20);

if ($события != []) {
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
		
	if ($text=='ё') {
		$bot_icq->sendText($chatId, "клмн");
	}elseif ($text=='/start') {
		$реплика = "Здравствуй ".$firstName."\n\nПопробуй команду /help";
		$bot_icq->sendText($chatId, $реплика);
	}elseif ($text=='/help') {
		/*if ($nick == 'Ogneyar_') {
			$реплика = "Список понимаемых мною команд:\n\nё\nПривет\nКак дела?\nеее\nуфь\n\n/exit";
		}else */$реплика = "Список понимаемых мною команд:\n\nё\nПривет\nКак дела?\nеее\nуфь";
			$bot_icq->sendText($chatId, $реплика);
	}/*elseif ($text=='/exit') {
		if ($nick == 'Ogneyar_') {
			$события = $bot_icq->getEvents($eventId,0);
			break;
		}
	}*/elseif ($text=='Привет') {
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
	
	_событие($eventId);
	
}

//$bot_icq->sendText("@Ogneyar_", "Цикл окончен.");

?>