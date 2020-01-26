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
	
	$query = "CREATE TABLE IF NOT EXISTS `avtozakaz_pzmarket` (
	  `id_client` bigint(20) DEFAULT NULL,
	  `id_zakaz` int(20) DEFAULT NULL,
	  `kuplu_prodam` varchar(100) DEFAULT NULL,
	  `nazvanie` varchar(500) DEFAULT NULL,
	  `url_nazv` varchar(200) DEFAULT NULL,
	  `valuta` varchar(100) DEFAULT NULL,
	  `gorod` varchar(200) DEFAULT NULL,
	  `username` varchar(200) DEFAULT NULL,
	  `doverie` tinyint(1) DEFAULT NULL,
	  `otdel` varchar(100) DEFAULT NULL,
	  `format_file` varchar(20) DEFAULT NULL,
	  `file_id` varchar(200) DEFAULT NULL,
	  `url_podrobno` varchar(200) DEFAULT NULL,
	  `status` varchar(20) DEFAULT NULL,
	  `podrobno` blob,
	  `url_tgraph` varchar(200) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	
	if ($result = $mysqli->query($query)) {
	
		$bot->sendMessage($master, "Всё отлично!");		
		
	}else throw new Exception("Не смог создать таблицу");
	
	
	
	
	
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
			
			exit('ok');
			
		}else throw new Exception("Пусто..");	
		
	}else throw new Exception("Не смог..");	
	
	
	
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