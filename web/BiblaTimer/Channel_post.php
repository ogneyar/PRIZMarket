<?
/*
if (strpos($text, ":")!==false) {

	$komanda = strstr($text, ':', true);	
	
	$id = substr(strrchr($text, ":"), 1);
	
	$text = $komanda;

}
*/

$дата = date("m.d.y");
	
$время = date("H:i:s");

$UNIXtime = time();
	
$переведённая_дата = date("d.m.Y H:i:s", $UNIXtime);

if ($text == 'старт') {

	if ($id_bota == '1098126237') {	
		
		$bot->sendMessage($channel_info, "?".$UNIXtime);
	
	}else exit('ok');

}elseif ($text == 'стоп') exit('ok');

$bot->sendMessage($channel_info, $UNIXtime);

$ожидание = 10;

sleep($ожидание);

$bot->sendMessage($channel_info, $UNIXtime+$ожидание);
	
$UNIXtime = time();
	
$bot->sendMessage($channel_info, $UNIXtime);

exit('ok');




?>