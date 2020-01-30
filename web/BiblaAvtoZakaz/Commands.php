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
	
	
}elseif ($text == 'мед') {
	
	if ($id) {
	
		$bot->output_table($таблица_медиагруппа, $id);
	
	}else {
		
		$bot->output_table($таблица_медиагруппа);
		
	}		
	
	
}elseif ($text == 'изи') {
	
	$query = "ALTER TABLE `avtozakaz_pzmarket` ADD `foto_album` BOOLEAN NULL DEFAULT NULL";
	
	if ($result = $mysqli->query($query)) {
	
		$bot->sendMessage($master, "Всё отлично!");
		
	}else throw new Exception("Не смог изменить таблицу");
	
	
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
		
		
}elseif ($text == "граф") {		
	
	$файлАйди = "AgACAgIAAxkBAAIGul4x3cTPtVld9yIqiwhnjrUSLzVTAAJ2rTEbWhCRSf7PQqiN1XQdha_CDwAEAQADAgADeQADy_ICAAEYBA";
	
	$Объект_файла = $bot->getFile($файлАйди);		
	
	$file_url = $bot->fileUrl . $bot->token;	
	
	$url = $file_url . "/" . $Объект_файла['file_path'];
	
	$результат = $Tgraph->createPagePhoto("Название", $url, true);
	
	if ($результат) {
		
		//$bot->sendMessage($master, $результат['path']);
		
		$path = $результат['path'];
		
		$результат = $Tgraph->getPage($path, true);
		
	}else throw new Exception("Не смог выложить пост..");	
	
	$реплика = "[абырвалг]({$результат['image_url']})\n\nглаврыба\n\nабырвалг\n\nглаврыба\n\nабырвалг\n\nглаврыба\n\nабырвалг\n\nглаврыба\n\nабырвалг\n\nглаврыба\n\nабырвалг\n\nглаврыба\n\nабырвалг\n\nглаврыба\n\nабырвалг\n\nглаврыба\n\nабырвалг\n\nглаврыба\n\nабырвалг\n\nглаврыба\n\nабырвалг\n\n";	
	
	$bot->sendMessage($channel_info, $реплика, markdown);
		
		
}elseif ($text == "имг") {		
	
	$файлАйди = "AgACAgIAAxkBAAIG5F4zH1NhqVZ6W437tdmcbUWhNla_AAJ_rDEbuTmZSZSx1SrrCC75iRvBDgAEAQADAgADeQAEPwIAARgE";
	
	$Объект_файла = $bot->getFile($файлАйди);		
	
	$file_url = $bot->fileUrl . $bot->token;	
	
	$url = $file_url . "/" . $Объект_файла['file_path'];	
	
	$результат = $imgBB->upload($url);
	
	if ($результат) {
		
		//$bot->sendMessage($master, $результат['path']);
		
		$imgBB_url = $результат['url'];		
		
	}else throw new Exception("Не смог выложить пост..");	
	
	$реплика = "[абырвалг]({$imgBB_url}) - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба\n\nабырвалг - главрыба";	
	
	$bot->sendMessage($channel_info, $реплика, markdown);
		
		
}









?>