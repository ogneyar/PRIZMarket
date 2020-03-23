<?
/* Список всех функций:
**
** exception_handler	-	// функция отлова исключений
**
** ----------------------
** _старт_СайтБота
** ----------------------
**
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
	
	$bot->sendMessage($chat_id, "Добро пожаловать, *".$callback_from_first_name."*!", markdown, $HideKeyboard);	
	exit('ok');	
}



?>
