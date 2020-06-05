<?

if ($callbackData == "najmimenya") {
	
	$результат = $bot_icq->answerCallbackQuery($queryId, "Ай молодец)))");	
	if ($результат['ok'] == false) $bot_icq->sendText($userId, "Ошибка: {$результат['description']}");
	/*
	$msg = $message['payload']['msgId'];
	$bot_icq->sendText($userId, $msg);
	
	$txt = $message['payload']['text'];
	$bot_icq->sendText($userId, $txt);
	*/
	$событие = json_encode($event);
	$bot_icq->sendText($userId, $событие);
	
	if ($txt == "Нажми кнопку!") $реплика = "Хорошо, а ещё?";
	else $реплика = "Нажми кнопку!";
	
	$bot_icq->editText($userId, $msg, $реплика, $кнопа);	
	
}elseif ($callbackData == "BBB") {

	$результат = $bot_icq->answerCallbackQuery($queryId, "Вот такой вот тут текст", true);
	
	if ($результат['ok'] == false) $bot_icq->sendText($userId, "Ошибка: {$результат['description']}");
	
}


?>