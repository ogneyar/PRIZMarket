<?

$UNIXtime = time() + $три_часа;	
$переведённое_время = date("d.m.Y H:i:s", $UNIXtime);

$запуск = _запуск_таймера();

if ($text == 'старт' || $text == '') {

	if ($id_bota == '1098126237') {	
		
		$запуск = _запуск_таймера('старт');
		
		$bot->sendMessage($channel_info, "?".$переведённое_время);
		
		exit('ok');
	
	}else exit('ok');

}elseif ($text == 'стоп') {
	
	$запуск = _запуск_таймера('стоп');
	
	exit('ok');
	
}elseif ($запуск) {
	
	

}

$bot->sendMessage($channel_info, $переведённое_время);

$ожидание = 19;

sleep($ожидание);

$переведённое_время = date("d.m.Y H:i:s", $UNIXtime+$ожидание);

$bot->sendMessage($channel_info, $переведённое_время);
	
$UNIXtime = time() + $три_часа;

$переведённое_время = date("d.m.Y H:i:s", $UNIXtime);
	
$bot->sendMessage($channel_info, $переведённое_время);

exit('ok');




?>