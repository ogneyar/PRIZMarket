<?
/*
if (strpos($text, ":")!==false) {

	$komanda = strstr($text, ':', true);	
	
	$id = substr(strrchr($text, ":"), 1);
	
	$text = $komanda;

}
*/

//$дата = date("m.d.y");
	
//$время = date("H:i:s");

$UNIXtime = time();
	
$переведённое_время = date("d.m.Y H:i:s", $UNIXtime);

//$переведённое_время = date("H:i:s", $UNIXtime);

if ($text == 'старт' || $text == '') {

	if ($id_bota == '1098126237') {	
		
		$bot->sendMessage($channel_info, "?".$переведённое_время);
		
		exit('ok');
	
	}else exit('ok');

}elseif ($text == 'стоп') exit('ok');

$bot->sendMessage($channel_info, $переведённое_время);

$ожидание = 29;

sleep($ожидание);

$переведённое_время = date("d.m.Y H:i:s", $UNIXtime+$ожидание);

$bot->sendMessage($channel_info, $переведённое_время);
	
$UNIXtime = time();

$переведённое_время = date("d.m.Y H:i:s", $UNIXtime);
	
$bot->sendMessage($channel_info, $переведённое_время);

exit('ok');




?>