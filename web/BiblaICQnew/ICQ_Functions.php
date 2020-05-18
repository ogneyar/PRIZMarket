<?
// реакция бота на команду старт
function _старт() {	
	global $bot_icq, $chatId, $firstName;
	$реплика = "Здравствуй ".$firstName."\n\nСписок понимаемых мною команд: \n\n/Privet \n/KakDela \n/eee \n/uf";
	$bot_icq->sendText($chatId, $реплика);
}



?>
