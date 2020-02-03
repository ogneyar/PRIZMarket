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


}elseif ($text == 'изи') {
	
	$query = "ALTER TABLE `avtozakaz_pzmarket` ADD `url_info_bot` VARCHAR( 200 ) NULL DEFAULT NULL";
	
	if ($result = $mysqli->query($query)) {
	
		$bot->sendMessage($master, "Всё отлично!");
		
	}else throw new Exception("Не смог изменить таблицу {$table_users}");	
	
	
	
}elseif ($text == 'креат') {
	
	$query = "CREATE TABLE IF NOT EXISTS `avtozakaz_mediagroup` (
		  `id` int(10) DEFAULT NULL,
		  `id_client` bigint(20) DEFAULT NULL,
		  `media_group_id` bigint(20) DEFAULT NULL,
		  `format_file` varchar(20) DEFAULT NULL,
		  `file_id` varchar(200) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	
	if ($result = $mysqli->query($query)) {
	
		$bot->sendMessage($master, "Всё отлично!");
		
	}else throw new Exception("Не смог изменить таблицу {$table_users}");	
	
	
	
}elseif ($text == 'топ') {
	
	$query = "SELECT user_name FROM info_users";
	
	if ($result = $mysqli->query($query)) {
	
		if ($result->num_rows>0) {
			
			$arrayResult = $result->fetch_all(MYSQLI_ASSOC);
			
			foreach ($arrayResult as $row) {
				
				try{
				
					$bot->sendMessage($channel_info, $row['user_name']);
				
				}catch (Exception $e) {
					
					$bot->sendMessage($master, "Видимо нет юзернейма.");
					
				}
			
			}
			
			$bot->sendMessage($master, "Всё отлично!");
			
		}else throw new Exception("Пусто..");	
		
	}else throw new Exception("Не смог..");	
	
	
	
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
		
		
}



?>