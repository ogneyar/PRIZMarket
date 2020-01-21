<?

if ($text == 'table message'||$text == 'таблица сообщений'||$text == 'соо') {
	
	$bot->output_table($table_message);	
	
		
}elseif ($text == 'база') {

	$bot->output_table($table_users);


}elseif ($text == 'изи') {
	
	$query = "ALTER TABLE `zakaz_message` CHANGE `date` `date` BIGINT NULL DEFAULT NULL";
	if (!$result = $mysqli->query($query)) throw new Exception("Не смог изменить таблицу {$table_message}");
	
	
}elseif ($text == 'дел') {
	
	_deleting_old_records($table_message);	
	
}



?>