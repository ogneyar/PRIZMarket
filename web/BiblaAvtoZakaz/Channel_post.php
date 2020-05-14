<?
$number = stripos($text, '#');

if ($number !== false && $number == '0') {

	_ожидание_публикации();

}elseif (isset($photo)) {

	if (stripos($caption, ':') !== false) {
		if (strstr($caption, ':', true) == "Логин") {
			$логин = substr(strrchr($caption, ":"), 1);	
			$query ="UPDATE {$table_market} SET file_id='{$file_id}' WHERE id_client='7' AND username='{$логин}' AND status=''";
			$result = $mysqli->query($query);		
			if ($result) {
				$bot->sendMessage($channel_info, "Записал в базу file_id этого фото.");
			}
		}
	}

}else {

	if ($text != '?' && $text != '!') {
			
		foreach ($entities as $ent) {			
			if ($ent['type'] == 'text_mention') $user = $ent['user'];			
		}
		if ($user) {					
			$url_info = "https://t.me/check_user_infobot?start=".$user['id'];				
			_запись_в_таблицу_маркет($user['id'], 'url_info_bot', $url_info);
		}

	}

}


?>