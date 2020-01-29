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


}elseif ($text == 'марк') {
	
	if ($id) {
	
		$bot->output_table($table_market, $id);
	
	}else {
		
		$bot->output_table($table_market);
		
	}		
	
	
}elseif ($text == 'ож') {
	
	if ($id) {
	
		$bot->output_table($таблица_ожидание, $id);
	
	}else {
		
		$bot->output_table($таблица_ожидание);
		
	}		
	
	
}elseif ($text == 'изи') {
	
	$query = "ALTER TABLE `avtozakaz_pzmarket` ADD `foto_album` BOOLEAN NULL DEFAULT NULL";
	
	if ($result = $mysqli->query($query)) {
	
		$bot->sendMessage($master, "Всё отлично!");
		
	}else throw new Exception("Не смог изменить таблицу");
	
	
}elseif ($text == 'креат') {
	
	$query = "CREATE TABLE IF NOT EXISTS `avtozakaz_ojidanie` (
		  `id_client` bigint(20) DEFAULT NULL,
		  `ojidanie` varchar(200) DEFAULT NULL,
		  `last` varchar(200) DEFAULT NULL,
		  `flag` tinyint(1) DEFAULT NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	
	if ($result = $mysqli->query($query)) {
	
		$bot->sendMessage($master, "Всё отлично!");
		
	}else throw new Exception("Не смог изменить таблицу");
	
	
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
		
	$result = $bot->sendMessage($channel_podrobno, $id);
	
	if (!$result) throw new Exception("Не смог выложить пост..");	
		
		
}



?>