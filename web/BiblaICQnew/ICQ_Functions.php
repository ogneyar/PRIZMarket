<?
// реакция бота на команду старт
function _старт() {	
	global $bot_icq, $chatId, $firstName;
	$реплика = "Здравствуй ".$firstName."\n\nПопробуй команду /help";
	$bot_icq->sendText($chatId, $реплика);
}



?>