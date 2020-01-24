<?

if (strpos($text, ":")!==false) {

	$komanda = strstr($text, ':', true);	
	
	$id = substr(strrchr($text, ":"), 1);
	
	$text = $komanda;

}


if ($text == 'соо') {
	
	
	
		
}elseif ($text == 'база') {

	

}elseif ($text == 'изи') {
	
	$query = "ALTER TABLE `zakaz_message` ADD `flag` BOOLEAN NULL DEFAULT NULL";
	if ($result = $mysqli->query($query)) {
		$bot->sendMessage($master, "Всё отлично!");
	}else throw new Exception("Не смог изменить таблицу {$table_message}");
	
	
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
	
		
}elseif ($text == "лот") {		
	
		$query = "SELECT * FROM ".$table5." WHERE id=".$id;
		if ($result = $mysqli->query($query)) {		
			
			if($result->num_rows>0){
				$arrStrok = $result->fetch_all();				
				foreach($arrStrok as $arrS){						
					foreach($arrS as $stroka) {
						if ($stroka==null) $stroka=" ";
						$sms.= "| ".$stroka." ";				
					}	
					$sms.="|\n\n";												
				}									
				
				_pechat($sms, '2000');				
				
			}else $tg->sendMessage($chat_id, "пуста таблица \xF0\x9F\xA4\xB7\xE2\x80\x8D\xE2\x99\x82\xEF\xB8\x8F");		
			
		}else throw new Exception("Не смог проверить таблицу ".$table5);
	
	
		
	}elseif ($text == "лоты") {		
		
		if (!$id) $id = '6500';
		
		$query = "SELECT id, otdel, caption2 FROM ".$table5;
		if ($result = $mysqli->query($query)) {		
			$sms="Таблица лотов:\n";
			if($result->num_rows>0){
				$arrStrok = $result->fetch_all();				
				foreach($arrStrok as $arrS){						
					foreach($arrS as $stroka) $sms.= "| ".$stroka." ";				
					$sms.="|\n";												
				}
				
				_pechat($sms, $id);
				
			}else $tg->sendMessage($chat_id, "пуста таблица \xF0\x9F\xA4\xB7\xE2\x80\x8D\xE2\x99\x82\xEF\xB8\x8F");		
			
		}else throw new Exception("Не смог проверить таблицу ".$table5);
	
		
		
	}



?>