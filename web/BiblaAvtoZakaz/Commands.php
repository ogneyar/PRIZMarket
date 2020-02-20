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
	
	$bot->sendMessage($master, "анука!");
	
	if ($id) {
	
		$bot->output_table($table_market, $id);
	
	}else {
		
		$bot->output_table($table_market);
		
	}		
	
	
}elseif ($text == 'ма') {
	
	$bot->sendMessage($master, "анука!");
	
	if ($id) {
		
		$bot->output_table_mini($table_market, $id);
	
	}else {
	
		$bot->output_table_mini($table_market);
		
	}		
	
	
}elseif (($text == "обнули фото альбом")&&($id)) {		
		
	$query = "UPDATE ".$table_market." SET foto_album='0' WHERE id_client=".$id." AND id_zakaz='0'";
	
	if ($result = $mysqli->query($query)) {
	
		$bot->sendMessage($master, "Всё отлично!");
		
	}else throw new Exception("Не смог изменить таблицу {$table_market}");	
		
		
}elseif ($text == 'ожид') {
	
	if ($id) {
	
		$bot->output_table($таблица_ожидание, $id);
	
	}else {
		
		$bot->output_table($таблица_ожидание);
		
	}		
	
	
}elseif ($text == 'меди') {
	
	if ($id) {
	
		$bot->output_table($таблица_медиагруппа, $id);
	
	}else {
		
		$bot->output_table($таблица_медиагруппа);
		
	}		
	
	
}elseif ($text == 'эди') {
	
	$хокей = $bot->editMessageText($channel_podrobno, $id, 'abuf');
	
	if ($хокей) $bot->sendMessage($master, "Всё отлично!");

	
	
}elseif ($text == 'эдит') {
	
	$хокей = $bot->editMessageText($channel_maket, $id, 'фига');
	
	if ($хокей) $bot->sendMessage($master, "Всё отлично!");

	
	
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
	
	
}elseif ($text == 'удали лот') {
	
	$query = "DELETE FROM ".$table_market." WHERE id_zakaz=".$id;				
	
	if ($result = $mysqli->query($query)) {
	
		$bot->sendMessage($master, "Всё отлично!");
		
	}else throw new Exception("Не смог изменить таблицу {$table_market}");	
	
	
}elseif ($text == 'удали медиа') {
	
	$query = "DELETE FROM ".$таблица_медиагруппа." WHERE id=".$id;				
	
	if ($result = $mysqli->query($query)) {
	
		$bot->sendMessage($master, "Всё отлично!");
		
	}else throw new Exception("Не смог изменить таблицу {$таблица_медиагруппа}");	
	
	
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
	
	//$bot->sendMessage($master, $bot->PrintArray($результат));
	
	if ($результат) {		
		
		$imgBB_url = $результат['url'];		
		
		//$imgBB_display_url = $результат['display_url'];		
		
	}else throw new Exception("Не смог выложить пост..");		
	
	$реплика = "[ ]({$imgBB_url})абырвалг - главрыба\n\nабырвалг - главрыба";	
	
	$bot->sendMessage($channel_podrobno, $реплика, markdown);
		
}elseif ($text == 'ае') {
	
	$bot->sendMessage($chat_id, "Лови", null, $ReplyKeyboardMarkup);
	
	
}elseif ($text == 'Вторая новая кнопка!') {

	$bot->sendMessage($chat_id, "Ремув", null, $ReplyKeyboardRemove);

}elseif ($text == 'Новая кнопка!') {

	$bot->sendMessage($chat_id, "Ремув", null, $HideKeyboard);

}elseif ($text == 'пуб') {

	$bot->sendMessage($chat_id, "Текст");
	
	sleep(10);
	
	$bot->sendMessage($chat_id, "Текст с задержкой");
	
	exit('ok');

	
	
}elseif ($text == 'рассылка') {
	
/*	
	$query = "SELECT DISTINCT id_client FROM `zakaz_users`";			
	if ($результат = $mysqli->query($query)) {	
		if ($результат->num_rows>0) {			
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);			
			foreach($результМассив as $строка) {			
				try{				
					$bot->sendMessage($строка['id_client'], "Здравствуйте!\n\nПроизведено обновление бота. ".
						"Для нормального функционирования и вообще ознакомления с новшествами - нажмите\n\n👉🏻 /start 👈🏻");				
				}catch (Exception $e) {					
					$bot->sendMessage($master, "ошибка");				
				}			
			}			
		}else $bot->sendMessage($master, "Нет записей в таблице `zakaz_users`");			
	}else $bot->sendMessage($master, "Не смог .. `zakaz_users`");	
*/
	
}elseif ($text == "обнули") {		
		
	$query = "UPDATE ".$table_market." SET date='0' WHERE id_zakaz=".$id;
	
	if ($result = $mysqli->query($query)) {
	
		$bot->sendMessage($master, "Всё отлично!");
		
	}else throw new Exception("Не смог изменить таблицу {$table_market}");	
		
		
}









?>
