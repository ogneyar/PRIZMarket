<?
/*
"message":{
		"chat":{
			"chatId":"752067062",
			"type":"private"
		},
		"from":{
			"firstName":"TesterPZMarket",
			"nick":"TesterBotoffBot",
			"userId":"752122979"
		},
		"msgId":"6834904851982320055",
		"parts":[{
			"payload":[[{
				"callbackData":"najmimenya",
				"text":"\u041d\u0430\u0436\u043c\u0438 \u043c\u0435\u043d\u044f"
			}],[{
				"callbackData":"ili",
				"text":"\u0438\u043b\u0438"
			}],[{
				"callbackData":"udalimenya",
				"text":"\u0423\u0434\u0430\u043b\u0438 \u043c\u0435\u043d\u044f"
			}]],
			"type":"inlineKeyboardMarkup"
		}],
		"text":"\u041d\u0430\u0436\u043c\u0438 \u043a\u043d\u043e\u043f\u043a\u0443!",
		"timestamp":1591375296
	}
*/
if ($callbackData == "najmimenya") {
	
	$результат = $bot_icq->answerCallbackQuery($queryId, "Ай молодец)))");	
	if ($результат['ok'] == false) $bot_icq->sendText($message['chat']['chatId'], "Ошибка: {$результат['description']}");
	
	$msg = $message['msgId'];
	$txt = $message['text'];
	/*
	$событие = json_encode($event);
	$bot_icq->sendText($message['chat']['chatId'], $событие);
	*/
	if ($txt == "Нажми кнопку!") $реплика = "Хорошо, а ещё?";
	else $реплика = "Нажми кнопку!";
	
	$bot_icq->editText($message['chat']['chatId'], $msg, $реплика, $кнопа);	
	
}elseif ($callbackData == "ili") {

	$результат = $bot_icq->answerCallbackQuery($queryId, "Или ничего)", true);	
	if ($результат['ok'] == false) $bot_icq->sendText($message['chat']['chatId'], "Ошибка: {$результат['description']}");
	
}elseif ($callbackData == "udalimenya") {

	$результат = $bot_icq->answerCallbackQuery($queryId, "Ой, ну и ладно(");	
	if ($результат['ok'] == false) $bot_icq->sendText($message['chat']['chatId'], "Ошибка: {$результат['description']}");
	
	​$bot_icq->deleteMessages($message['chat']['chatId'], $message['msgId']);	
	
}elseif ($callbackData == "BBB") {

	$результат = $bot_icq->answerCallbackQuery($queryId, "Вот такой вот тут текст", true);	
	if ($результат['ok'] == false) $bot_icq->sendText($message['chat']['chatId'], "Ошибка: {$результат['description']}");
	
}


?>