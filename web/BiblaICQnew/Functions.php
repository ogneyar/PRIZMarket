<?
// реакция бота на команду старт
function _старт_АйСиКюБота() {	
	global $bot, $chat_id;	
	$bot->sendMessage($chat_id, "Прива!");	
}
// запись в таблицу информации о последнем событии (Event)
function _событие($событие = null) {	
	global $mysqli;	
	$ответ = false;
	$запрос = "SELECT soderjimoe FROM `variables` WHERE id_bota='11' AND nazvanie='событие'";	
	$результат = $mysqli->query($запрос);	
	if ($результат) {		
		$количество = $результат->num_rows;		
		if ($количество > 0) {			
			if ($событие) {				
				$запрос = "UPDATE `variables` SET soderjimoe='{$событие}' WHERE id_bota='11' AND nazvanie='событие'";				
				$результат = $mysqli->query($запрос);				
				if ($результат) $ответ = true;			
			}else {			
				$результМассив = $результат->fetch_all(MYSQLI_ASSOC);			
				$ответ = $результМассив[0]['soderjimoe'];				
			}		
		}else {			
			if ($событие) {				
				$запрос = "INSERT INTO `variables` VALUES ('11', 'событие', '{$событие}', 'номер последнего события', '')";				
				$результат = $mysqli->query($запрос);				
				if ($результат) $ответ = true;				
			}			
		}		
	}	
	return $ответ;	
}




?>