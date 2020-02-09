<?

if (strpos($text, ":")!==false) {

	$komanda = strstr($text, ':', true);	
	
	$id = substr(strrchr($text, ":"), 1);
	
	$text = $komanda;

}

if ($id) {
	
	sleep($id);
	
	$bot->sendMessage($channel_info, "?Время");
	
}else {
	
	$дата = date("m.d.y");
	
	$время = date("H:i:s");
	
	$UNIXtime = time();
	
	$переведённая_дата = date("d.m.Y", $UNIXtime);
	
	$bot->sendMessage($channel_info, $дата);
	
}




?>