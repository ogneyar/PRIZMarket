<?

// функция старта бота ИНФОРМАЦИЯ О ПОЛЬЗОВАТЕЛЯХ
function _start_InfoBota() {		

	global $bot, $chat_id, $from_first_name, $HideKeyboard, $table_users;
	
	$bot->add_to_database($table_users);
	
	$bot->sendMessage($chat_id, "Добро пожаловать, *".$from_first_name."*!",
		markdown, $HideKeyboard);	
	
	_info_InfoBota();
	
	exit('ok');
	
}

function _info_InfoBota() {

	global $bot, $chat_id, $RKeyMarkup;
	
	$reply = "Перешлите мне чьё либо сообщение, я выдам Вам информацию о лице,".
		" его написавшем.";
//\n\nЛибо, пришлите его номер id.
	$bot->sendMessage($chat_id, $reply);

}

// функция вывода на печать массива
function PrintArr($mass, $i=0) {
	
	global $flag;
		
	$flag .= "\t\t\t\t";			
		
	foreach($mass as $key[$i] => $value[$i]) {				
		if (is_array($value[$i])) {
				$_this .= $flag . $key[$i] . " : \n";
				$_this .= PrintArr($value[$i], ++$i);
		}else $_this .= $flag . $key[$i] . " : " . $value[$i] . "\n";
	}
	$str = $flag;
	$flag = substr($str, 0, -4);
	return $_this;
	
}

// при возникновении исключения вызывается эта функция
function exception_handler($exception) {

	global $bot, $master;
	
	$bot->sendMessage($master, "Ошибка! ".$exception->getCode()." ".$exception->getMessage());	
  
	exit('ok');  
	
}



?>