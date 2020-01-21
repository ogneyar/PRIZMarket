<?

if ($text == 'база') {

	$bot->output_table($table_users, '240');
	


}elseif ($text == 'изи') {
	
	$query = "UPDATE `{$table_users}` SET `first_name` = 'Отрадъ' WHERE `id_client` =298466355";
	if ($result = $mysqli->query($query)) {
		$bot->sendMessage($master, "Всё отлично!");
	}else throw new Exception("Не смог изменить таблицу {$table_message}");	
	
}



?>