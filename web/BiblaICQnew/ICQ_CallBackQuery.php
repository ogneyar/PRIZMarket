<?
/*
$событие = json_encode($event);
$bot_icq->sendText($userId, $событие);
*/
$chat = $message['chat'];
	$chatId = $chat['chatId'];
	$type = $chat['type'];
$from = $message['from'];
	$firstName = $from['firstName'];
	$nick = $from['nick'];
	$userId = $from['userId'];
$msgId = $message['msgId'];
$parts = $message['parts'];
	$parts_payload = $parts[0]['payload'];
	$parts_type = $parts[0]['type'];
$text = $message['text'];
$timestamp = $message['timestamp'];

if ($callbackData == "najmimenya") {

	$результат = $bot_icq->answerCallbackQuery($queryId, "Ай молодец)))");	
	if ($результат['ok'] == false) $bot_icq->sendText($chatId, "Ошибка: {$результат['description']}");
	
	if ($text == "Нажми кнопку!") $реплика = "Хорошо, а ещё?";
	else $реплика = "Нажми кнопку!";
	
	$bot_icq->editText($chatId, $msgId, $реплика, $кнопа);	
	
}elseif ($callbackData == "ili") {

	$результат = $bot_icq->answerCallbackQuery($queryId, "Или ничего)", true);	
	if ($результат['ok'] == false) $bot_icq->sendText($chatId, "Ошибка: {$результат['description']}");
	
}elseif ($callbackData == "udalimenya") {
	$результат = $bot_icq->answerCallbackQuery($queryId, "Ой ну и ладно(");	
	if ($результат['ok'] == false) $bot_icq->sendText($chatId, "Ошибка: {$результат['description']}");
	
	$bot_icq->deleteMessages($chatId, [$msgId]);	
	
}elseif ($callbackData == "BBB") {

	$результат = $bot_icq->answerCallbackQuery($queryId, "Вот такой вот тут текст", true);	
	if ($результат['ok'] == false) $bot_icq->sendText($chatId, "Ошибка: {$результат['description']}");
	
}


?>