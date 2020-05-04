<?
/* Список всех функций:
**
** exception_handler	-	// функция отлова исключений
**
** ----------------------
** _старт_СайтБота
** ----------------------
**
** _проверка_заявок
*/

// при возникновении исключения вызывается эта функция
function exception_handler($exception) {
	global $bot, $master;	
	$bot->sendMessage($master, "Ошибка! ".$exception->getCode()." ".$exception->getMessage());	  
	exit('ok');  	
}

// функция старта бота ИНФОРМАЦИЯ О ПОЛЬЗОВАТЕЛЯХ
function _старт_СайтБота() {		
	global $bot, $table_users, $chat_id, $callback_from_first_name, $from_first_name, $HideKeyboard;	
	
	if (!$callback_from_first_name) $callback_from_first_name = $from_first_name;
	
	$bot->sendMessage($chat_id, "Добро пожаловать, *".$callback_from_first_name."*!", markdown, $HideKeyboard);	
	exit('ok');	
}
// функция проверки заявок клиентов на сайте
function _проверка_заявок() {	
	global $mysqli;	
	$ответ = false;
	$запрос = "SELECT * FROM `avtozakaz_pzmarket` WHERE id_client='7'";	
	$результат = $mysqli->query($запрос);	
	if ($результат) {		
		$количество = $результат->num_rows;		
		if ($количество > 0) {			
			$ответ = $результат->fetch_all(MYSQLI_ASSOC);
		}
	}	
	return $ответ;	
}


?>
