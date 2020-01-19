<?
// Если пришла ссылка типа t.me//..?start=123456789
if (strpos($text, "/start ")!==false) $text = str_replace ("/start ", "", $text);

// проверяем если пришло сообщение
if ($text) {

	if ($reply_to_message) {	
		
		if ($reply_forward) {
			
			// надо будет в базе сохранить $reply_forward_id
			$bot->sendMessage($reply_forward_id, $text, null, null, $reply_message_id);
			
		}elseif ($reply_sender_name) {
			
			$bot->sendMessage($chat_id, "Профиль скрыт.");
			
		}
			
	}elseif ($text=='инфо') {
		
        _info();
		
	}else {

		$bot->forwardMessage($admin_group, $chat_id, $message_id);

    }	
       
}elseif ($photo) {

    
}elseif ($video) {
	
	
}




?>
