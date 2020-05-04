<?
if (strpos($text, ":")!==false) {
	$komanda = strstr($text, ':', true);		
	$id = substr(strrchr($text, ":"), 1);	
	$text = $komanda;
}
if ($text == 'сенд') {	
	$bot_icq->sendText($ICQ_channel_market, "Здравствуйте дорогие товарищи!");
	
}elseif ($text=='дай айди') {		
	$bot_icq->sendText($chatId, "Вот - {$chatId}\nтип чата - {$chatType}");
	
}elseif ($text=='сендФ') {
	$файл = $file_get_contents("https://i.ibb.co/YZVdQrH/file-108.jpg");
	//$файл = "https://i.ibb.co/YZVdQrH/file-108.jpg";
	$bot_icq->sendFile($chatId, $файл);
	
}
?>