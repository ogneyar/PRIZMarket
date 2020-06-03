<?

if ($callbackData == "BBB") {
	
	$bot_icq->sendText($userId, "queryId: ".$queryId);
	
	$результат = $bot_icq->answerCallbackQuery($queryId, "Вот такой вот тут текст", true);
	
	if ($результат['ok'] == false) $bot_icq->sendText($userId, "Ошибка: {$результат['description']}");
	
}


?>