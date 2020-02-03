<?

foreach ($entities as $ent) {
	
	if ($ent['type'] == 'text_mention') $user = $ent['user'];
	
}

if ($user) {
		
	$url_info = "https://t.me/check_user_infobot?start=".$user['id'];	

	$bot->sendMessage($admin_group, $url_info, null, null, null, true);	

}







?>