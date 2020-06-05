<?

if ($callbackData == "najmimenya") {
	
	$результат = $bot_icq->answerCallbackQuery($queryId, "Ай молодец)))");	
	if ($результат['ok'] == false) $bot_icq->sendText($message['chatId'], "Ошибка: {$результат['description']}");
	
	$msg = $message['msgId'];
	$bot_icq->sendText($message['chatId'], $msg);
	
	$txt = $message['text'];
	$bot_icq->sendText($message['chatId'], $txt);
	/*
	$событие = json_encode($event);
	$bot_icq->sendText($message['chatId'], $событие);
	*/
	if ($txt == "Нажми кнопку!") $реплика = "Хорошо, а ещё?";
	else $реплика = "Нажми кнопку!";
	
	$bot_icq->editText($message['chatId'], $msg, $реплика, $кнопа);	
	
}elseif ($callbackData == "BBB") {

	$результат = $bot_icq->answerCallbackQuery($queryId, "Вот такой вот тут текст", true);
	
	if ($результат['ok'] == false) $bot_icq->sendText($message['chatId'], "Ошибка: {$результат['description']}");
	
}


?>