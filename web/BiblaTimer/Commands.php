<?
if (strpos($text, ":")!==false) {
	$komanda = strstr($text, ':', true);		
	$id = substr(strrchr($text, ":"), 1);	
	$text = $komanda;
}
if ($text == 'таймер') {	
	$ответ = "Не задан.";
	$запрос = "SELECT soderjimoe FROM `variables` WHERE id_bota='8' AND nazvanie='таймер'";	
	$результат = $mysqli->query($запрос);	
	if ($результат) {		
		$количество = $результат->num_rows;		
		if ($количество > 0) {			
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);			
			$ответ = $результМассив[0]['soderjimoe'];		
		}	
	}	
	$bot->sendMessage($master, $ответ);	
}elseif ($text == 'марк') {}
?>