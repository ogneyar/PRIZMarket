<?

if (strpos($text, ":")!==false) {

	$komanda = strstr($text, ':', true);	
	
	$id = substr(strrchr($text, ":"), 1);
	
	$text = $komanda;

}


if ($text == 'соо') {
	
	$bot->output_table($table_message);	
	
		
}elseif ($text == 'база') {

	if ($id) {
	
		$bot->output_table($table_users, $id);
	
	}else {
		
		$bot->output_table($table_users);
		
	}	


}elseif ($text == 'изи') {
	
	$query = "CREATE TABLE IF NOT EXISTS `avtozakaz_users` (
	  `id_client` bigint(20) DEFAULT NULL,
	  `first_name` varchar(500) DEFAULT NULL,
	  `last_name` varchar(500) DEFAULT NULL,
	  `user_name` varchar(200) DEFAULT NULL,
	  `status` varchar(10) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	
	if ($result = $mysqli->query($query)) {
	
		$bot->sendMessage($master, "Всё отлично!");
		
		$query = "INSERT INTO `avtozakaz_users` (`id_client`, `first_name`, `last_name`, `user_name`, `status`) VALUES
			(351009636, 'Ogneyar', NULL, '@Ogneyar_ya', 'admin'),
			(298466355, 'Otrad', NULL, '@Otrad_ya', 'admin'),
			(276795315, 'Rada', NULL, '@DJRADA', 'admin')";
			
		if ($result = $mysqli->query($query)) {
		
			$bot->sendMessage($master, "Тем более отлично!");
			
		}else throw new Exception("Не смог добавить записи в таблицу");
		
	}else throw new Exception("Не смог создать таблицу");
	
	
	
	
	
}elseif ($text == 'дел') {
	
	if(_deleting_old_records($table_message)) $bot->sendMessage($master, "Всё отлично!");
	
	
}elseif ($text == 'удали') {
	
	$query = "DELETE FROM ".$table_users." WHERE id_client=".$id;				
	
	if ($result = $mysqli->query($query)) {
	
		$bot->sendMessage($master, "Всё отлично!");
		
	}else throw new Exception("Не смог изменить таблицу {$table_users}");	
	
	
}elseif (($text == "админ")&&($id)) {		
		
	$query = "UPDATE ".$table_users." SET status='admin' WHERE id_client=".$id;
	
	if ($result = $mysqli->query($query)) {
	
		$bot->sendMessage($master, "Всё отлично!");
		
	}else throw new Exception("Не смог изменить таблицу {$table_users}");	
		
		
}elseif (($text == "-админ")&&($id)) {		
		
	$query = "UPDATE ".$table_users." SET status='client' WHERE id_client=".$id;
	
	if ($result = $mysqli->query($query)) {
	
		$bot->sendMessage($master, "Всё отлично!");
		
	}else throw new Exception("Не смог изменить таблицу {$table_users}");	
		
		
}elseif ($text == "пост"&&($id)) {		
		
	$result = $bot->sendMessage($channel_market, $id);
	
	if (!$result) throw new Exception("Не смог выложить пост..");	
		
		
}



?>