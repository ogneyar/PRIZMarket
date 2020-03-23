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
		$bot->sendMessage($admin_group, "Удаление из БД совершенно!");
	}else $bot->sendMessage($admin_group, "Не получается удалить строку из БД");	
	
}



?>
