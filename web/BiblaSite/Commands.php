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
	$command = "test";
	$description = "тестовое описание команды";
	$BotCommand = [
		[
			'command' => '',
			'description' => ''
		]
	];
	$bot->sendMessage($chat_id, "Вот.");
	$bot->sendMessage($chat_id, $BotCommand);
	$result = $bot->setMyCommands($BotCommand);	
	if ($result) {					
		$bot->sendMessage($chat_id, "Установил команды.");
	}else $bot->sendMessage($chat_id, "Не получается установить команды.");
	
}



?>
