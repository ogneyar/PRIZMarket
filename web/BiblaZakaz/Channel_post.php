<?

$number = stripos($text, 'Информация о пользователе:');
if ($number!==false) {
	
	$string = substr(strrchr($text, "id: "), 1);
	
	$id = strstr($string, 10, true);	
	
	$text = substr(strrchr($string, 10), 1);
	
	$text.= "Информация о пользователе:\n".
		"id: [".$id."](tg://user?id=".$id.")\n".$text;
	
	$bot->sendMessage($channel_info, $text);
	
}





?>