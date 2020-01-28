<?

if ($text=='Отмена ввода') {

	$bot->sendMessage($chat_id, "Ввод отменён.", null, $HideKeyboard);
	
	$result = _ожидание_ввода();	
	
	if ($result) {
	
		if ($result['last'] == 'kuplu_prodam') {			
			
			_очистка_таблицы_ожидание();
			
			_создать();
		
		}elseif ($result['last'] == 'nazvanie') {
		
			_очистка_таблицы_ожидание();
			
			_ссылка_в_названии();
		
		}
		
	}else _start_AvtoZakazBota();
	

}else { 
	
	$result = _ожидание_ввода();
	
	if ($result) {
		
		if ($result['ojidanie'] == 'nazvanie') {
			
			_запись_в_таблицу_маркет('nazvanie', $text);
			
			_очистка_таблицы_ожидание();
			
			$bot->sendMessage($chat_id, "Принял.", null, $HideKeyboard);
			
			_ссылка_в_названии();
			
		}elseif ($result['ojidanie'] == 'url_nazv') {
			
			_запись_в_таблицу_маркет('url_nazv', $text);			
			
			_очистка_таблицы_ожидание();
			
			$bot->sendMessage($chat_id, "Принял.", null, $HideKeyboard);
			
			_выбор_валюты();
			
		}
		
	}else $bot->deleteMessage($chat_id, $message_id);
	

}
	

  
  




?>
