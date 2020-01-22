<?

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





?>