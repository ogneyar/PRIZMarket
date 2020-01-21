<?

if ($text == 'база') {

	$bot->output_table($table_users);


}elseif ($text == 'изи') {
	
	$query = "UPDATE `zakaz_users` SET `first_name` = '{$from_first_name}', `last_name` = '', `user_name` = '@Ogneyar' WHERE `id_client` =351009636";
	if ($result = $mysqli->query($query)) {
		$bot->sendMessage($master, "Всё отлично!");
	}else throw new Exception("Не смог изменить таблицу {$table_message}");
	
	
}



?>