<?
$UNIXtime = time();
$UNIXtime_Moscow = $UNIXtime + $три_часа;	/*
$дата_и_время = date("d.m.Y H:i:s", $UNIXtime_Moscow);
$дата = date("d.m.Y", $UNIXtime_Moscow);
$время = date("H:i:s", $UNIXtime_Moscow);
$час = date("H", $UNIXtime_Moscow);
$минута = date("i", $UNIXtime_Moscow);*/
$секунда = date("s", $UNIXtime_Moscow);

$ожидание = _в_ожидании();
if ($ожидание == 'есть') exit('ok');
_в_ожидании('есть');

$eventId = _событие();
if (!$eventId) {
	$eventId = 0;
	_событие($eventId);
}

echo "ok";

//$bot_icq->sendText("@Ogneyar_", "Начало положено.");

if ($секунда >= 40) {
	$ожидание = 59 - $секунда; 
}elseif ($секунда >= 20) {
	$ожидание = 39 - $секунда;
}else {
	$ожидание = 19 - $секунда; 
}	

$события = $bot_icq->getEvents($eventId, $ожидание);

if ($события != []) {	
	foreach($события as $event) {
		$eventId = $event['eventId'];		
		$payload = $event['payload'];
			$queryId = $payload['queryId'];
			$chat = $payload['chat'];
				$chatId = $chat['chatId'];
				$chatType = $chat['type'];
				$chatTitle = $chat['title'];
			$from = $payload['from'];
				$firstName = $from['firstName'];
				$lastName = $from['lastName'];
				$nick = $from['nick'];
				$userId = $from['userId'];
			$message = $payload['message']; // это массив
			$msgId = $payload['msgId'];
			$text = $payload['text'];
			$callbackData = $payload['callbackData'];
			$timestamp = $payload['timestamp'];
		$type = $event['type'];
	}	

	include_once 'ICQ_Functions.php';
	if ($type == "newMessage"){					
		$number = stripos($text, '%');					
		if ($number!==false&&$number == '0') {						
			if ($userId == $ICQmaster) {						
				$text = substr($text, 1);							
				include_once 'ICQ_Commands.php';
			}else include_once 'ICQ_Message.php';
		}else include_once 'ICQ_Message.php';
	}elseif ($type == "callbackQuery"){
		include_once 'ICQ_CallBackQuery.php';
	}
	
	_событие($eventId);
	
	_в_ожидании('нет');
			
	$bot_timer = new Bot($tokenTimer);
	$bot_timer->sendMessage($channel_info, "!");
	
}else _в_ожидании('нет');

//$bot_icq->sendText("@Ogneyar_", "Цикл окончен.");

?>