<?
$number = stripos($text, '#');

if ($number != false && $number == '0') {
/*
	$UNIXtime = time();
	$UNIXtime_Moscow = $UNIXtime + $три_часа;	
	$дата_и_время = date("d.m.Y H:i:s", $UNIXtime_Moscow);
	$дата = date("d.m.Y", $UNIXtime_Moscow);
	$время = date("H:i:s", $UNIXtime_Moscow);
	$час = date("H", $UNIXtime_Moscow);
	$минута = date("i", $UNIXtime_Moscow);
	$секунда = date("s", $UNIXtime_Moscow);
*/	

	$bot->sendMessage($master, "еее");
	_ожидание_публикации();

}else {

	if ($text != '?') {
			
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