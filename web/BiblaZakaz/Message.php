<?

if ($reply_to_message) {	

	if ($reply_forward) {
			
		// $reply_forward_id - это айди клиента написавшего сообщение боту,
		// из базы надо будет достать message_id клиента по reply_forward_id (id клиента)
		// осуществив поиск reply_message_id,  которое в базе записано как
		// message_id_out
			
		$query = "SELECT message_id_in FROM {$table_message} WHERE message_id_out={$reply_message_id} AND client_id={$reply_forward_id}";
		if ($result = $mysqli->query($query)) {				
			if($result->num_rows>0){
				$arrayResult = $result->fetch_all(MYSQLI_ASSOC);				
				$message_id_in = $arrayResult[0]['message_id_in'];
			}				
		}else throw new Exception("Не смог узнать message_id_in в таблице {$table_message}");
			
		if ($text) {
			
			$result = $bot->sendMessage($reply_forward_id, $text, null, null, $message_id_in);
				
		}elseif ($photo) {			
			
			$result = $bot->sendPhoto($reply_forward_id, $file_id, null, null, null, $message_id_in);
			
		}elseif ($video) {
			
			$result = $bot->sendVideo($reply_forward_id, $file_id, null, null, null, $message_id_in);
			
		}
				
			
		if ($result) {
			
			// а после надо сохранить айди сообщения админа клиенту
			// для возможности его редактирования
			
			$query = "INSERT INTO {$table_message} VALUES ('{$reply_forward_id}',
				'{$message_id}', '{$result['message_id']}', '{$result['date']}', '0')";
			$mysql_result = $mysqli->query($query);
					
			if (!$mysql_result) throw new Exception("Не смог сделать записать в таблицу {$table_message}");
		}
			
			
	}elseif ($reply_sender_name) {
			
		$bot->sendMessage($chat_id, "Профиль скрыт.");
			
	}elseif ($chat_type == 'private') {			

		$result = $bot->forwardMessage($admin_group, $chat_id, $message_id);
			
		if ($result) {			
			
			$entry_flag = _entry_flag($table_message);
			
			if ($entry_flag) {
				
				$entry_flag = '0';
			
			}else {
				
				$entry_flag = '1';
				
				_info_otvetnoe();		
				
			}
			
			$query = "INSERT INTO {$table_message} VALUES ('{$chat_id}',
				'{$message_id}', '{$result['message_id']}', '{$result['date']}', '{$entry_flag}')";
			$mysql_result = $mysqli->query($query);
					
			if (!$mysql_result) throw new Exception("Не смог сделать записать в таблицу {$table_message}");
				
		}			
	
	}
	
}elseif ($text=='инфо') {
		
       _info_Zakaz_bota();
		
}elseif ($text=='пост'||$text == 'post') {
		
	$result = $bot->forwardMessage($channel_info, $chat_id, $message_id);
		   
	if ($result) {
			   
		$result = $bot->sendMessage($channel_info, "@".$from_username);
			   
		if ($result) {
					
			$result = $bot->sendMessage($channel_info, "&".$from_id);
				
		}
			   
	}		   
	
				
}else { // если просто текст, фото или видео, безовсяких ответов и пересылок
		
	if ($chat_type == 'private') {  // если в личку боту		
			
		_deleting_old_records($table_message, $day/2);
		
		$entry_flag = _entry_flag($table_message);
			
		// клиент написал, надо в базе сохранить его id, message_id_in, date 
		// (и id_message_out, которое будет найдено ниже)
		// что бы потом с базы доставать message_id по date зная id клиента)			
		
		$result = $bot->forwardMessage($admin_group, $chat_id, $message_id);
					
		if ($result) {
			
			// флаг проверки отправленного ответного сообщения
			if ($entry_flag) {
				
				$entry_flag = '0';
			
			}else {
				
				$entry_flag = '1';
				
				_info_otvetnoe();
			
				if (strpos($text, "t.me/prizm_market") == false && $reply_markup['inline_keyboard'][0][0]['text']!='Подробнее') _format_links();
				
			}
			
			// номер сообщения, которое бот отправил в админку
			// по этому номеру будет находиться message_id клиента,
			// когда админ ответит на сообщение (reply_to_message)
			
			$query = "INSERT INTO {$table_message} VALUES ('{$chat_id}',
				'{$message_id}', '{$result['message_id']}', '{$result['date']}', '{$entry_flag}')";
			$mysql_result = $mysqli->query($query);
				
			if (!$mysql_result) throw new Exception("Не смог сделать записать в таблицу {$table_message}");
				
		}
		
	}
	
}	
  
  




?>
