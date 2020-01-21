<?

if ($message_forward) {	

	if ($forward_username!='') $forward_username = "@".$forward_username;
		
	$forward_first_name = str_replace ("_", "\_", $forward_first_name);
	$forward_last_name = str_replace ("_", "\_", $forward_last_name);
	$forward_username = str_replace ("_", "\_", $forward_username);
		
	$reply = "Информация о пользователе:\n".
		"id: [".$forward_id."](tg://user?id=".$forward_id.")\n".
		"first name: ".$forward_first_name."\n".
		"last name: ".$forward_last_name."\n".
		"username: ".$forward_username;
		
	$bot->sendMessage($chat_id, $reply, markdown);	
		
			
	$from_id = $forward_id;
	$from_first_name = $forward_first_name;			
	$from_last_name = $forward_last_name;
	$from_username = $forward_username;
			
	$bot->add_to_database($table_users);
		
		
}elseif ($forward_sender_name){
		
	$bot->sendMessage($chat_id, $forward_sender_name."\n\nПрофиль скрыт.");
		
}elseif ($text=='Настройки'){
		
	$bot->sendMessage($chat_id, PrintArr($data));
		
}elseif ($text=='Стоп'){
		
	$reply = "Всего Вам доброго! До новых встречь!\n\nДля возврата жмите /start";
		
	$bot->sendMessage($chat_id, $reply, null, $HideKeyboard);
			
			
}elseif ($text){		
				
	$result = $bot->getChat($text);
		
	if (!$result) {
			
		if ($chat_type=='private') _info(); 
		
	}else {
			
					
		if ($result['username']!='') $result['username'] = "@".$result['username'];
			
		$result['first_name'] = str_replace ("_", "\_", $result['first_name']);
		$result['last_name'] = str_replace ("_", "\_", $result['last_name']);
		$result['username'] = str_replace ("_", "\_", $result['username']);
			
		$reply = "Информация о пользователе:\n".
			"id: [".$result['id']."](tg://user?id=".$result['id'].")\n".
			"first name: ".$result['first_name']."\n".
			"last name: ".$result['last_name']."\n".
			"username: ".$result['username'];
		
		$bot->sendMessage($chat_id, $reply, markdown);		
		
		
		$from_id = $result['id'];
		$from_first_name = $result['first_name'];			
		$from_last_name = $result['last_name'];
		$from_username = $result['username'];
			
		$bot->add_to_database($table_users);
		
	}
		
}	




?>
