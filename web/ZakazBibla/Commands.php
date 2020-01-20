<?

if ($text == 'table message'||$text == 'таблица сообщений'||$text == 'соо') {
	
	$query = "SELECT * FROM ".$table_message;
	if ($result = $mysqli->query($query)) {		
		$reply="Таблица сообщений:\n";
		if($result->num_rows>0){
			$arrayResult = $result->fetch_all();				
			foreach($arrayResult as $row){						
				foreach($row as $stroka) $reply.= "| ".$stroka." ";
				$reply.="|\n";							
			}					
					
			_output($reply, '4000');
				
		}else $tg->sendMessage($chat_id, "пуста таблица ".
				" \xF0\x9F\xA4\xB7\xE2\x80\x8D\xE2\x99\x82\xEF\xB8\x8F");		
				
	}else throw new Exception("Не смог получить записи в таблице {$table_message}");
		
}elseif ($text == 'изи') {
	
	$query = "ALTER TABLE `zakaz_message` CHANGE `date` `date` BIGINT NULL DEFAULT NULL";
	if (!$result = $mysqli->query($query)) throw new Exception("Не смог изменить таблицу {$table_message}");
	
	
}



?>