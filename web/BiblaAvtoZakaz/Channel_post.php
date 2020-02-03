<?

foreach ($entities as $ent) {
	
	if ($ent['type'] == 'text_mention') $user = $ent['user'];
	
}

if ($user) {	
		
	$url_info = "https://t.me/check_user_infobot?start=".$user['id'];	
	
	_запись_в_таблицу_маркет($user['id'], 'url_info_bot', $url_info);

	//$bot->sendMessage($admin_group, $url_info, null, null, null, true);		

}

	





?>