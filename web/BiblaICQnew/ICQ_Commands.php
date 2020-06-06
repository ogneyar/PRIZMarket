<?
if (strpos($text, ":")!==false) {
	$komanda = strstr($text, ':', true);		
	$id = substr(strrchr($text, ":"), 1);	
	$text = $komanda;
}

if ($text == 'сенд') {	

	$bot_icq->sendText($ICQ_channel_market, "Здравствуйте дорогие товарищи!");
	
	
}elseif ($text == 'дай айди') {	
	
	$bot_icq->sendText($chatId, "Вот - {$chatId}\nтип чата - {$chatType}");
	
	
}elseif ($text == 'члены') {

	$результат = $bot_icq->getMembers($chatId);
	if ($результат['ok']) {
		//$bot_icq->sendText($chatId, $результат['members'][0]['userId']);
		
		$событие = json_encode($результат);
		$bot_icq->sendText($chatId, $событие);
		
	}elseif ($chatType == 'private') {
		$bot_icq->sendText($chatId, "Тут только Ты и Я");
	}else $bot_icq->sendText($chatId, "Ошибка: ".$результат['description']);
	
	
}elseif ($text == 'админы') {

	$результат = $bot_icq->getAdmins($chatId);
	if ($результат['ok']) {
		$bot_icq->sendText($chatId, $результат['admins'][0]['userId']);
	}elseif ($chatType == 'private') {
		$bot_icq->sendText($chatId, "Тут только Ты и Я");
	}else $bot_icq->sendText($chatId, "Ошибка: ".$результат['description']);
	
	
}elseif ($text == 'экшн') {
	$результат = $bot_icq->​sendActions($chatId, "typing"); // typing - печатает..  // looking - не сработал(
	if ($результат['ok'] == false) $bot_icq->sendText($chatId, "Ошибка: {$результат['description']}");
	
	
}elseif ($text == 'гетинфо') {

	$результат = $bot_icq->getInfo($chatId);	
	if ($результат['ok'] == false) $bot_icq->sendText($chatId, "Ошибка: {$результат['description']}");
	else {
		if ($результат["type"] == 'private') $bot_icq->sendText($chatId, $результат["firstName"]);
		else $bot_icq->sendText($chatId, $результат["title"]);		
	}
	/*
	$событие = json_encode($результат);
	$bot_icq->sendText($chatId, $событие);
	*/
	
	
}elseif ($text == 'сендФ') {

	//$файл = "https://i.ibb.co/YZVdQrH/file-108.jpg";

        $файл = "http://f0430377.xsph.ru/video/video1.mp4";

	$bot_icq->sendFile($chatId, $файл, "а тут типа текст");

	//$bot_icq->sendText($chatId, "Х.З.");
	
}elseif ($text == 'кноп') {		

	$файл = "https://i.ibb.co/YZVdQrH/file-108.jpg";
	
	$кнопа = [
		[
			[
				"text" => "🌎 Visit website",
				"url" => "http://mail.ru"
			],
			[
				"text" => "🤖 Make a query",
				"callbackData" => "BBB"
			]
		]
	];
	
	$bot_icq->sendText($chatId, "Вот\n\n{$файл}", $кнопа);
	
}elseif ($text == 'file_get_contents_text') {		
	
	$token = "001.2839288818.3919878723:752122979";
	$chatId = "752067062";
	$text = "TTTTtttt";
	
	$headers = stream_context_create([
		'http' => [
			'method' => 'POST',
			'header' => 'Content-Type: application/x-www-form-urlencoded' . PHP_EOL,
			'content' => http_build_query([
				'token' => $token,
				'chatId' => $chatId,
				'text' => $text//,
				//'replyMsgId' => $replyMsgId,			
				//'forwardChatId' => $forwardChatId,				
				//'forwardMsgId' => $forwardMsgId,			
				//'inlineKeyboardMarkup' => $inlineKeyboardMarkup
			])
		],
	]);
 
	file_get_contents('https://api.icq.net/bot/v1/messages/sendText', false, $headers);
	
}



?>