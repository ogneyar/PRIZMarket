<?
if (strpos($text, ":")!==false) {
	$komanda = strstr($text, ':', true);		
	$id = substr(strrchr($text, ":"), 1);	
	$text = $komanda;
}

if ($text == 'база') {
	if ($id) {	
		$bot->output_table($table_users, $id);	
	}else {		
		$bot->output_table($table_users);		
	}	
	
}elseif ($text == 'удали') {
	$query = "DELETE FROM {$table_users} WHERE login='{$id}'";				
	if ($result = $mysqli->query($query)) {					
		$bot->sendMessage($chat_id, "Удаление из БД совершенно!");
	}else $bot->sendMessage($chat_id, "Не получается удалить строку из БД");
	
}elseif ($text == 'сетком') {
	$BotCommand = [
		[
			'command' => "start",
			'description' => "Главное меню"
		]
	];
	$bot->sendMessage($chat_id, "Вот.");
	$bot->sendMessage($chat_id, $BotCommand);
	$result = $bot->setMyCommands($BotCommand);	
	if ($result) {					
		$bot->sendMessage($chat_id, "Установил команды.");
	}else $bot->sendMessage($chat_id, "Не получается установить команды.");
	
}elseif ($text == 'сендДок') {	
	//$фото = "https://i.ibb.co/YZVdQrH/file-108.jpg";
	$фото = "https://i.gifer.com/72Sz.gif";
	//$file = file_get_contents($фото);
	$результат = $bot->sendDocument($chat_id, $фото);
	if ($результат) {					
		$bot->sendMessage($chat_id, "Кууль.");
	}else $bot->sendMessage($chat_id, "Не кууль.");
	
}elseif ($text == 'сенд') {	
	$фото = "https://i.ibb.co/YZVdQrH/file-108.jpg";	
	//$file = file_get_contents($фото);	
	//$InputMediaPhoto = [ ['type' => 'photo', 'media' => $file] ];	
	//$InputMediaPhoto = json_encode($InputMediaPhoto);
	$результат = $bot->sendAnimation($chat_id, $фото);
	if ($результат) {					
		$bot->sendMessage($chat_id, "Кууль.");
		$bot->PrintArray($результат);
	}else $bot->sendMessage($chat_id, "Не кууль.");
	
}



?>
