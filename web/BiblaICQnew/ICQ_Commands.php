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
	
}elseif ($text == 'сендФ') {
	//$файл = file_get_contents("https://i.ibb.co/YZVdQrH/file-108.jpg");
	$файл = "https://i.ibb.co/YZVdQrH/file-108.jpg";
	$bot_icq->sendFile($chatId, $файл);
	
	/*$url = "https://i.ibb.co/YZVdQrH/file-108.jpg";
	$файл = new CURLFile($url, 'image/jpeg', 'file-108.jpg');
	$bot_icq->sendFile($chatId, $файл);*/

	//include_once 'test.php';
	$bot_icq->sendText($chatId, "Х.З.");
	
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
	
}


?>