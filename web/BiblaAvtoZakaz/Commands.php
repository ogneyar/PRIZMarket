<?
if (strpos($text, ":")!==false) {
	$komanda = strstr($text, ':', true);		
	$id = substr(strrchr($text, ":"), 1);	
	$text = $komanda;
}else $id = '';

if ($text == 'база') {
	if ($id) {	
		$bot->output_table($table_users, $id);	
	}else {		
		$bot->output_table($table_users);		
	}	
	
}elseif ($text == 'бан') {	
	$query = "UPDATE ".$table_users." SET status='ban' WHERE user_name=".$id;
	if ($result = $mysqli->query($query)) {	
		$bot->sendMessage($master, "Всё отлично!");		
	}else throw new Exception("Не смог изменить таблицу `variables`");		
		
}elseif ($text == 'варя') {	
	$bot->output_table('variables');		
		
}elseif ($text == 'удалиЭу') {	
	$query = "DELETE FROM `variables` WHERE id_bota='1011417080' AND soderjimoe<'125'";		
	if ($result = $mysqli->query($query)) {	
		$bot->sendMessage($master, "Всё отлично!");		
	}else throw new Exception("Не смог изменить таблицу `variables`");		
	
}elseif ($text == 'удали очередь') {	
	$query = "DELETE FROM `variables` WHERE id_bota='1011417080'";		
	if ($result = $mysqli->query($query)) {	
		$bot->sendMessage($master, "Всё отлично!");		
	}else throw new Exception("Не смог изменить таблицу `variables`");		
	
}elseif ($text == 'лотывк') {
	
	$bot->output_table('vk_url');
	
	
}elseif ($text == 'время') {
	$bot->sendMessage($chat_id, time());
	
}elseif ($text == 'маркет') {	
	if ($id) {	
		_список_всех_лотов($id);	
	}else {		
		_список_всех_лотов();		
	}			
	
}elseif ($text == 'марк') {	
	if ($id) {	
		$bot->output_table($table_market, $id);	
	}else {		
		$bot->output_table($table_market);		
	}			
	
}elseif ($text == 'марксайт') {	
	if ($id) {	
		_вывод_списка_лотов_клиента($table_market, $id);	
	}else {		
		_вывод_списка_лотов_клиента($table_market);		
	}			
	
}elseif ($text == 'где') {
	
	//$результат = $vk2->uploadAndGetUrl($vk_album_id, $vk_group_id, $ссылка_на_файл);
	
	$file = "http://f0430377.xsph.ru/image/Дом.jpg";
	$result = $vk2->photosGetUploadServer($vk_album_id, $vk_group_id);	
	if ($result['error_msg']) {
		$bot->sendMessage($master, "Ошибка: ".$result['error_msg']);		
		exit;
	}
	$bot->sendMessage($master, "upload_url: ".$result['upload_url']);	
	$result = $vk2->upload($result['upload_url'], $file);
	$server = $result['server'];
	$photos_list = $result['photos_list'];
	$hash = $result['hash'];	
	if ($photos_list == []) {
		$bot->sendMessage($master, "photos_list пуст");		
		exit;
	}
	$bot->sendMessage($master, "server: ".$result['server']);
	$bot->sendMessage($master, "photos_list: ".$result['photos_list']);
	$bot->sendMessage($master, "hash: ".$result['hash']);
	$result = $vk2->photosSave($vk_album_id, $vk_group_id, $server, $photos_list, $hash);
	if ($result['error_msg']) {
		$bot->sendMessage($master, "Ошибка: ".$result['error_msg']);		
		exit;
	}
	$url_vk = "https://vk.com/photo".$result[0]['owner_id']."_".$result[0]['id'];
	$vk_file = "photo".$result[0]['owner_id']."_".$result[0]['id'];
	foreach($result[0]['sizes'] as $size) {		
		$url = $size['url'];			
	}				
	$response['url_vk'] = $url_vk;
	$response['vk_file'] = $vk_file;
	$response['url'] = $url;	
		
	$bot->sendMessage($master, "url_vk: ".$response['url_vk']);
	$bot->sendMessage($master, "vk_file: ".$response['vk_file']);
	$bot->sendMessage($master, "url: ".$response['url']);
	
	
	$bot->sendMessage($master, "Всё отлично!");		
	
	
}elseif ($text == 'ма') {
	
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

	
	
}elseif ($text == 'перенесены') {
	
	//_покажи_перенесённые_лоты();
	
	$query = "SELECT id_zakaz FROM {$table_market} WHERE status='перенесён'";			
	if ($результат = $mysqli->query($query)) {	
		if ($результат->num_rows>0) {			
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);			
			foreach($результМассив as $строка) {			
				$bot->sendMessage($master, $строка['id_zakaz']);
			}			
		}else $bot->sendMessage($master, "Нет записей в таблице {$table_market}");			
	}else $bot->sendMessage($master, "Не смог .. {$table_market}");	
	
	
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
	
	$реплика = "[абырвалг]({$результат['image_url']})\n\nглаврыба\n\nабырвалг";	
	
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
		
		
}elseif ($text == "обну") {		
		
	$query = "UPDATE ".$table_market." SET date='0' WHERE id_client=".$master;
	
	if ($result = $mysqli->query($query)) {
	
		$bot->sendMessage($master, "Всё отлично!");
		
	}else throw new Exception("Не смог изменить таблицу {$table_market}");	
		
		
}elseif ($text == "обн") {		
		
	$query = "UPDATE ".$table_market." SET date='0' WHERE username='{$id}' AND id_client='7'";
	
	if ($result = $mysqli->query($query)) {
	
		$bot->sendMessage($master, "Всё отлично!");
		
	}else throw new Exception("Не смог изменить таблицу {$table_market}");	
		
		
}elseif ($text == "измени хеш продам") {		
		
	$результат = _редакт_таблицы_маркет($id, 'kuplu_prodam', '#продам');
	
	if ($результат) $bot->sendMessage($master, "Всё отлично!");
		
}elseif ($text == "измени хеш куплю") {		
		
	$результат = _редакт_таблицы_маркет($id, 'kuplu_prodam', '#куплю');
	
	if ($результат) $bot->sendMessage($master, "Всё отлично!");

}elseif ($text == "рэди") {		
	
	$bot->editMessageText($admin_group, "22354", "Лот 1169 опубликован.
https://t.me/prizm_market/4482", null, null, true);

}elseif ($text == 'удали лот по имени') {
	
	$query = "DELETE FROM ".$table_market." WHERE id_client='7' AND username='{$id}' AND status=''";
	
	if ($result = $mysqli->query($query)) {
	
		$bot->sendMessage($master, "Всё отлично!");
		
	}else throw new Exception("Не смог изменить таблицу {$table_market}");

}







?>
