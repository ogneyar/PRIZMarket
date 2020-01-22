<?

$number = stripos($text, 'Информация о пользователе:');
if ($number!==false) {
	
	$string = substr(strrchr($text, "id: "), 4);
	
	$id = strstr($string, 10, true);	
	
	$text = substr(strrchr($string, 10), 1);
	
	$text.= "Информация о пользователе:\n".
		"id: [".$forward_id."](tg://user?id=".$forward_id.")\n".$text;
	
	$bot->sendMessage($channel_info, $text);
	
}





?>