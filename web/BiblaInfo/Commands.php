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


}elseif ($text == 'обнова') {
		
	$query = "SELECT * FROM `pzmarkt`";				
	
	if ($результат = $mysqli->query($query)) {
	
		if ($результат->num_rows>0) {
			
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);
			
			foreach($результМассив as $строка) {
				
				$номер_заказа = $строка['id'];						
				
				$категория = $строка['otdel'];
				if ($строка['format_file'] == 'video') {
					
					$формат_файла = 'видео';
					
				}else {
					
					$формат_файла = 'фото';
					
				}
				$файлАйди = $строка['file_id'];		
				$ссыль_в_названии = $строка['url'];
				$куплю_или_продам = $строка['kuplu_prodam'];
				
				$название = str_replace('▪', '', $строка['nazvanie']);				
				$валюта = str_replace('▪', '', $строка['valuta']);				
				$хештеги_города = str_replace('▪', '', $строка['gorod']);				
				//$юзера_имя = str_replace('▪', '', $строка['username']);			
				//$юзера_имя = str_replace(' ', '', $юзера_имя);						
				$юзера_имя = strstr($строка['username'], '@');				
				
				$bot->sendMessage($master, $юзера_имя);
				
				if ($строка['doverie'] == '0') {
					
					$доверие = '0';
					
				}else {
				
					$доверие = '1';
					
				}
				$ссыль_на_подробности = $строка['podrobno'];	
				$время = $строка['time'];
				
				
				$запрос = "SELECT username FROM `avtozakaz_pzmarket` WHERE id_zakaz='{$номер_заказа}'";		
				$результат = $mysqli->query($запрос);	
				if ($результат) {		
					if ($результат->num_rows > 0) {		
						$bot->sendMessage($master, "такой заказ уже есть");	
					}else {
						
						$айди_клиента = '';
						
						$query = "SELECT id_client FROM `zakaz_users` WHERE user_name='{$юзера_имя}'"; 
						$result = $mysqli->query($query);
						if ($result) {
							if ($result->num_rows > 0) {
								$результат = $result->fetch_all(MYSQLI_ASSOC);
								$айди_клиента = $результат[0]['id_client'];
							}else {
								$bot->sendMessage($master, "Нет записей в таблице `zakaz_users`");
								continue;
							}
						}else {
							$bot->sendMessage($master, "Не смог .. `zakaz_users`");	
							continue;							
						}
						
						if ($айди_клиента) {
						
							$query = "INSERT INTO `avtozakaz_pzmarket` (
							  `id_client`, `id_zakaz`, `kuplu_prodam`, `nazvanie`,  `url_nazv`,  `valuta`, `gorod`,
							  `username`, `doverie`, `otdel`, `format_file`, `file_id`, `url_podrobno`, `status`,
							  `podrobno`, `url_tgraph`, `foto_album`, `url_info_bot`, `date`
							) VALUES (
							  '{$айди_клиента}', '{$номер_заказа}', '{$куплю_или_продам}', '{$название}', '{$ссыль_в_названии}', '{$валюта}', '{$хештеги_города}', '{$юзера_имя}', '{$доверие}', '{$категория}', '{$формат_файла}', '{$файлАйди}', '{$ссыль_на_подробности}', 'перенесён', '', '', '', '', '{$время}'
							)";
										
							$result = $mysqli->query($query);
							
							if ($result) {
								$bot->sendMessage($master, "новая запись");
							}else $bot->sendMessage($master, "Не смог добавить запись в таблицу `avtozakaz_pzmarket`");
						
						}else $bot->sendMessage($master, "Не смог найти айди клиента..");			
	
	
	
					}
				}else $bot->sendMessage($master, "Нет такого заказа..");					
				
			}
			
			
		}else $bot->sendMessage($master, "Нет записей в таблице `pzmarkt`");					
		
	}else $bot->sendMessage($master, "Не смог .. `pzmarkt`");	
	
	
	
	
}elseif ($text == 'изи') {
	
	$query = "ALTER TABLE `pzmarkt` CHANGE `caption1` `kuplu_prodam` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
CHANGE `caption2` `nazvanie` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
CHANGE `caption3` `valuta` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
CHANGE `caption4` `gorod` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
CHANGE `caption5` `username` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL";
	
	if ($result = $mysqli->query($query)) {
	
		$bot->sendMessage($master, "Всё отлично!");
		
	}else throw new Exception("Не смог изменить таблицу {$table_users}");	
	
	
	
}elseif ($text == 'креат') {
	
	$query = "CREATE TABLE IF NOT EXISTS `variables` (
		  `id_bota` bigint(20) DEFAULT NULL,
		  `nazvanie` varchar(100) DEFAULT NULL,
		  `soderjimoe` varchar(200) DEFAULT NULL,
		  `opisanie` varchar(500) DEFAULT NULL,
		  `vremya` bigint(20) DEFAULT NULL
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