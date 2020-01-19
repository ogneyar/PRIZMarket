<?
// Если пришла ссылка типа t.me//..?start=123456789
if (strpos($text, "/start ")!==false) $text = str_replace ("/start ", "", $text);

// проверяем если пришло сообщение
if ($text) {

	if ($reply_to_message) {	

		if ($reply_forward) {
			
			// $reply_forward_id - это айди клиента написавшего сообщение боту,
			// из базы надо будет достать message_id клиента по reply_forward_id
			// осуществив поиск reply_message_id,  которое в базе записано как
			// id_message_in_group
			$result = $bot->sendMessage($reply_forward_id, $text);
			
			//, null, null, $reply_message_id
			
			
			// а после надо сохранить айди сообщения админа клиенту
			// для возможности его редактирования
			
			
			
		}elseif ($reply_sender_name) {
			
			$bot->sendMessage($chat_id, "Профиль скрыт.");
			
		}
	
	}elseif ($text=='инфо') {
		
        _info();
		
	}else {
		
		// клиент написал, надо в базе сохранить его id, message_id, date 
		// (и id_message_in_group, которое будет найдено ниже)
		// что бы потом с базы доставать message_id по date зная id клиента)
		$result = $bot->forwardMessage($admin_group, $chat_id, $message_id);
		
		$result = json_decode($result, true);
		
		if ($result['ok']) {
			
			// номер сообщения, которое бот отправил в админку
			// по этому номеру будет находиться message_id клиента,
			// когда админ ответит на сообщение (reply_to_message)
			$id_message_in_group = $result['result']['message_id'];
			
		}

    }	
       
}elseif ($photo) {

    
}elseif ($video) {
	
	
}




?>
