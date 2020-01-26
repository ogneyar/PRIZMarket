<?

foreach ($entities as $ent) {
	
	if ($ent['type'] == 'text_mention') $user = $ent['user'];
	
}

if ($user) {
	
	if ($id_bota == '475440299') {
	
		$url_info = "https://t.me/check_user_infobot?start=".$user['id'];
						
	}elseif ($id_bota == '1052297281') {
						
		$url_info = "https://t.me/Ne_wTest_Bot?start=".$user['id'];
							
	}

	$bot->sendMessage($admin_group, $url_info, null, null, null, true);	

}




/*
$number = stripos($text, 'Информация о пользователе:');

if ($number!==false) {	
	
	//$string = strrchr($text, ":");
	
	$string = substr(strstr($text, "id: "), 4);
	
	$id = strstr($string, 10, true);	
	
	$text = substr(strrchr($string, 10), 1);
	
	$textA.= "Информация о пользователе:\n".
		"id: [".$id."](tg://user?id=".$id.")\n".$text;
	
	$bot->sendMessage($channel_info, $textA);
	
}
*/




?>