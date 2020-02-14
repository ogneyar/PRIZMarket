<?

foreach ($entities as $ent) {
	
	if ($ent['type'] == 'text_mention') $user = $ent['user'];
	
}

if ($user) {	
		
	$url_info = "https://t.me/check_user_infobot?start=".$user['id'];	
	
	_запись_в_таблицу_маркет($user['id'], 'url_info_bot', $url_info);

	//$bot->sendMessage($admin_group, $url_info, null, null, null, true);		

}
	
	
$url_text = $reply_markup['inline_keyboard'][0][0]['text'];

if ($url_text) {
	
	$bot->sendMessage($master, $url_text);
		
}else $bot->sendMessage($master, "Неа");
	
	
if ($url_text == 'Подробнее') {

	$url_podrobnee = $reply_markup['inline_keyboard'][0][0]['url'];

	$номер_заказа = substr(strrchr($url_podrobnee, '/'), 1);	
	
	$query ="UPDATE {$table_market} SET file_id='{$file_id}' WHERE id_zakaz={$номер_заказа}";
		
	$result = $mysqli->query($query);
			
	if ($result) {
	
		$bot->sendMessage($master, "обновил");
		
	}else $bot->sendMessage($master, "Не смог обновить запись в таблице {$table_market}");

}
	


?>