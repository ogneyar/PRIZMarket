<?

if ($text=='Отмена ввода') {

	$bot->sendMessage($chat_id, "Ввод отменён.", null, $HideKeyboard);
	
	$result = _ожидание_ввода();	
	
	if ($result) {
	
		if ($result['last'] == 'kuplu_prodam') {			
			
			_создать();
		
		}
		
	}else _start_AvtoZakazBota();
	

}else { 
	
	$result = _ожидание_ввода();
	
	if ($result) {
		
		if ($result->ojidanie == 'nazvanie') {
			
			_запись_в_таблицу_маркет('nazvanie', $text);
			
			_ссылка_в_названии();
			
		}
		
	}else $bot->deleteMessage($chat_id, $message_id);
	

}
	

  
  




?>
