<?

$number = stripos($text, 'Информация о пользователе:');
if ($number!==false) {
	
	//$text = 
	
	//$string = strrchr($text, ":");
	
	$string = strrchr($text, "id: ");
	
	//$string = substr(strstr($text, "id: "), 4);
	
	$id = strstr($string, 10, true);	
	
	$text = substr(strrchr($string, 10), 1);
	
	$textA.= "Информация о пользователе:\n".
		"id: [".$id."](tg://user?id=".$id.")\n".$text;
	
	$bot->sendMessage($channel_info, $textA);
	
}





?>