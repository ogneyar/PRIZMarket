<?
$UNIXtime = time();
$UNIXtime_Moscow = $UNIXtime + $три_часа;	
$дата_и_время = date("d.m.Y H:i:s", $UNIXtime_Moscow);
$дата = date("d.m.Y", $UNIXtime_Moscow);
$время = date("H:i:s", $UNIXtime_Moscow);
$час = date("H", $UNIXtime_Moscow);
$минута = date("i", $UNIXtime_Moscow);
$секунда = date("s", $UNIXtime_Moscow);
if ($text == 'старт') {	
	if ($id_bota == '1098126237' || $id_bota == '1145916719') {		
		$запуск = _запуск_таймера('старт');	
		if ($запуск) {
			$bot->sendMessage($channel_info, "#".$время);			
			$bot->sendMessage($channel_info, "?");			
		}
	}
	exit('ok');
}elseif ($text == 'стоп') {	
	if ($id_bota == '1098126237' || $id_bota == '1145916719') {	
		$запуск = _запуск_таймера('стоп');	
		if ($запуск) $bot->sendMessage($channel_info, "Остановил.");			
	}	
	exit('ok');		
}else $запуск = false;
$запуск = _запуск_таймера();
if ($запуск == 'старт') {
	$ожидание = _в_ожидании();
	if ($ожидание == 'есть') exit('ok');
	else $ожидание = _в_ожидании('есть');
	$пора_показать_время = false;
	if ($секунда >= 40) {
		$ожидание = 60 - $секунда; // если 40 ожидание 20 секунд если 59, то 1 секунду
		$пора_показать_время = true;
	}elseif ($секунда >= 20) {
		$ожидание = 40 - $секунда; // если 20 ожидание 20 секунд если 39, то 1 секунду
	}else {
		$ожидание = 20 - $секунда; // если 0 ожидание 20 секунд если 19, то 1 секунду
	}	
	sleep($ожидание);
	if ($пора_показать_время) {
		$UNIXtime = time();
		$UNIXtime_Moscow = $UNIXtime + $три_часа;	
		$время = date("H:i:s", $UNIXtime_Moscow);
		sleep(4);
		$bot->sendMessage($channel_info, "#".$время);	
	}
	$ожидание = _в_ожидании('нет');
	$bot->sendMessage($channel_info, "?");		
	exit('ok');
}else exit('ok');


?>
