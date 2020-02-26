<?
$number = stripos($text, '#');

if ($number == false $number != '0') {

	if ($chat_id == $channel_info && $text != '?') {
					
		$result = $bot->getChat($text);
			
		if ($result) {		
		
			$from_id = $result['id'];
			$from_first_name = $result['first_name'];			
			$from_last_name = $result['last_name'];
			$from_username = $result['username'];
				
			$bot->add_to_database($table_users);
			
			
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
			
		}
		
	}

}




?>