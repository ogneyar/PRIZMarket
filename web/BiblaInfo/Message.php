<?
// Если пришла ссылка типа t.me//..?start=123456789
if (strpos($text, "/start ")!==false) $text = str_replace ("/start ", "", $text);

// проверяем если пришло сообщение
if ($text) {

	if ($message_forward) {	

		if ($forward_username!='отсутствует') $forward_username = "@".$forward_username;
		
		$forward_first_name = str_replace ("_", "\_", $forward_first_name);
		$forward_last_name = str_replace ("_", "\_", $forward_last_name);
		$forward_username = str_replace ("_", "\_", $forward_username);
		
		$reply = "Информация о пользователе:\n".
			"id: [".$forward_id."](tg://user?id=".$forward_id.")\n".
			"first name: ".$forward_first_name."\n".
			"last name: ".$forward_last_name."\n".
			"username: ".$forward_username;
		
		$bot->sendMessage($chat_id, $reply, markdown);	
		
	}elseif ($forward_sender_name){
		
		$bot->sendMessage($chat_id, $forward_sender_name."\n\nПрофиль скрыт.");
		
	}elseif ($text=='Настройки'){
		
		$bot->sendMessage($chat_id, PrintArr($data));
		
	}elseif ($text=='Стоп'){
		
		$reply = "Всего Вам доброго! До новых встречь!\n\nДля возврата жмите /start";
		
		$bot->sendMessage($chat_id, $reply, null, $HideKeyboard);
			
			
	}else{
		
		$result = $bot->getChat($text);
		
		if (!$result) {
			
			if ($chat_type=='private') _info(); 
		
		}else {
			
			if ($result['last_name']=='') $result['last_name'] = 'неизвестно';
			
			if ($result['username']=='') $result['username'] = 'неизвестно';
			else $result['username'] = "@".$result['username'];
			
			$result['first_name'] = str_replace ("_", "\_", $result['first_name']);
			$result['last_name'] = str_replace ("_", "\_", $result['last_name']);
			$result['username'] = str_replace ("_", "\_", $result['username']);
			
			$reply = "Информация о пользователе:\n".
				"id: [".$result['id']."](tg://user?id=".$result['id'].")\n".
				"first name: ".$result['first_name']."\n".
				"last name: ".$result['last_name']."\n".
				"username: ".$result['username'];
		
			$bot->sendMessage($chat_id, $reply, markdown);		
		
		}
		
	}	
       
}elseif ($chat_type=='private') {

    // если пришло что-то другое
    $bot->call('sendMessage', ['chat_id' => $chat_id, 'text' => "Чего это такое?"]);
}




?>
