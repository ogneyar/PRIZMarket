<?

if ($text == 'база') {

	$bot->output_table($table_users, '260');
	


}elseif ($text == 'изи') {
	
	$query = "UPDATE `{$table_users}` SET `first_name` = 'Отрадъ', `last_name` = '', `user_name` = '@Otrad_ya' WHERE `id_client` =298466355";
	if ($result = $mysqli->query($query)) {
		$bot->sendMessage($master, "Всё отлично!");
	}else throw new Exception("Не смог изменить таблицу {$table_message}");	
	
}



?>