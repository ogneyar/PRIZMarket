<?

if ($reply_to_message) {	
	
	$query = "SELECT message_id_out FROM {$table_message} WHERE message_id_in={$message_id} AND client_id={$reply_forward_id}";
	
	if ($result = $mysqli->query($query)) {				
	
		if($result->num_rows>0){
		
			$arrayResult = $result->fetch_all(MYSQLI_ASSOC);				
			
			$message_id_out = $arrayResult[0]['message_id_out'];
			
		}else throw new Exception("Отсутствует запись о сообщении в таблице {$table_message}");
		
	}else throw new Exception("Не смог узнать message_id_out в таблице {$table_message}");
			
	$result = $bot->editMessageText($reply_forward_id, $message_id_out, $text);			

	if (!$result) throw new Exception("Не смог изменить сообщение");
	
			
}elseif ($chat_type == 'private') {

	$query = "SELECT message_id_out FROM {$table_message} WHERE message_id_in={$message_id} AND client_id={$chat_id}";
	
	if ($result = $mysqli->query($query)) {				
	
		if($result->num_rows>0){
		
			$arrayResult = $result->fetch_all(MYSQLI_ASSOC);				
			
			$message_id_out = $arrayResult[0]['message_id_out'];
			
		}else throw new Exception("Отсутствует запись о сообщении в таблице {$table_message}");
		
	}else throw new Exception("Не смог узнать message_id_in в таблице {$table_message}");
			
	$result = $bot->editMessageText($admin_group, $message_id_out, $text);			

	if (!$result) throw new Exception("Не смог изменить сообщение");

}




?>