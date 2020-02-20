<?
// реакция бота на команду старт
function _старт_ТаймерБота() {
	
	global $bot, $chat_id;
	
	$bot->sendMessage($chat_id, "Прива!");
	
}


// запись в таблицу информации о страрте или остановке таймера
function _запуск_таймера() {
	
	global $mysqli;
	
	$ответ = false;
	
	$запрос = "SELECT soderjimoe FROM `variables` WHERE id_bota='8' AND nazvanie='таймер'";
	
	$результат = $mysqli->query($запрос);
	
	if ($результат) {
		
		$количество = $результат->num_rows;
		
		if ($количество > 0) {
			
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);
			
			$ответ = $результМассив[0]['soderjimoe'];
			
		}else {
			
			
		
		}
		
	}
	
}












?>
