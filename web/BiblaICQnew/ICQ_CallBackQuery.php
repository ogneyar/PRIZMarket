<?

if ($callbackData == "BBB") {
	
	//$bot_icq->answerCallbackQuery($queryId, "Вот такой вот тут текст", true);
	
	$bot_icq->sendText($chatId, $queryId);
	
}

?>