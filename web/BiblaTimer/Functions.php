<?
// реакция бота на команду старт
function _старт_ТаймерБота() {	
	global $bot, $chat_id;	
	$bot->sendMessage($chat_id, "Прива!");	
}
// запись в таблицу информации о страрте или остановке таймера
function _запуск_таймера($команда = null) {	
	global $mysqli;	
	$ответ = false;
	$запрос = "SELECT soderjimoe FROM `variables` WHERE id_bota='8' AND nazvanie='таймер'";	
	$результат = $mysqli->query($запрос);	
	if ($результат) {		
		$количество = $результат->num_rows;		
		if ($количество > 0) {			
			if ($команда == 'стоп') {				
				$запрос = "DELETE FROM `variables` WHERE id_bota='8' AND nazvanie='таймер'";				
				$результат = $mysqli->query($запрос);
				if ($результат) $ответ = true;				
			}elseif ($команда == 'старт') {				
				$запрос = "UPDATE `variables` SET soderjimoe='старт' WHERE id_bota='8' AND nazvanie='таймер'";				
				$результат = $mysqli->query($запрос);				
				if ($результат) $ответ = true;			
			}else {			
				$результМассив = $результат->fetch_all(MYSQLI_ASSOC);			
				$ответ = $результМассив[0]['soderjimoe'];				
			}		
		}else {			
			if ($команда == 'старт') {				
				$запрос = "INSERT INTO `variables` VALUES ('8', 'таймер', 'старт', 'таймер запущен', '')";				
				$результат = $mysqli->query($запрос);				
				if ($результат) $ответ = true;				
			}			
		}		
	}	
	return $ответ;	
}
// запись в таблицу информации о работе таймера (об ожидании отклика бота)
function _в_ожидании($команда = null) {	
	global $mysqli;	
	$ответ = false;
	$запрос = "SELECT soderjimoe FROM `variables` WHERE id_bota='8' AND nazvanie='ожидание'";	
	$результат = $mysqli->query($запрос);	
	if ($результат) {		
		$количество = $результат->num_rows;		
		if ($количество > 0) {			
			if ($команда == 'нет') {				
				$запрос = "DELETE FROM `variables` WHERE id_bota='8' AND nazvanie='ожидание'";				
				$результат = $mysqli->query($запрос);
				if ($результат) $ответ = true;				
			}elseif ($команда == 'есть') {				
				$запрос = "UPDATE `variables` SET soderjimoe='есть' WHERE id_bota='8' AND nazvanie='ожидание'";				
				$результат = $mysqli->query($запрос);				
				if ($результат) $ответ = true;			
			}else {			
				$результМассив = $результат->fetch_all(MYSQLI_ASSOC);			
				$ответ = $результМассив[0]['soderjimoe'];				
			}		
		}else {			
			if ($команда == 'есть') {				
				$запрос = "INSERT INTO `variables` VALUES ('8', 'ожидание', 'есть', 'ожидание отклика бота', '')";				
				$результат = $mysqli->query($запрос);				
				if ($результат) $ответ = true;				
			}			
		}		
	}	
	return $ответ;	
}




?>