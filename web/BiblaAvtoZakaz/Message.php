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
		
		}elseif ($result['last'] == 'valuta') {
		
			_очистка_таблицы_ожидание();
			
			_выбор_валюты();
		
		}elseif ($result['last'] == 'gorod') {
		
			_очистка_таблицы_ожидание();
			
			_ввод_местонахождения();
		
		}elseif ($result['last'] == 'format_file') {
		
			_очистка_таблицы_ожидание();
			
			_отправьте_файл();
		
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
			
		}elseif ($result['ojidanie'] == 'gorod') {
			
			_запись_в_таблицу_маркет('gorod', $text);			
			
			_очистка_таблицы_ожидание();
			
			$bot->sendMessage($chat_id, "Принял.", null, $HideKeyboard);
			
			_отправьте_файл();
			
		}elseif ($result['ojidanie'] == 'format_file') {
		
			if ($photo) $format_file = 'фото';
			
			if ($video) $format_file = 'видео';
			
			if ($photo||$video) {
			
				_запись_в_таблицу_маркет('format_file', $format_file);

				_запись_в_таблицу_маркет('file_id', $file_id);
				
				_очистка_таблицы_ожидание();
				
				$bot->sendMessage($chat_id, "Принял.", null, $HideKeyboard);
				
				_опишите_подробно();
				
			}else $bot->deleteMessage($chat_id, $message_id);
			
		}elseif ($result['ojidanie'] == 'podrobno') {
		
			_запись_в_таблицу_маркет('podrobno', $text);

			_очистка_таблицы_ожидание();
			
			$bot->sendMessage($chat_id, "Принял.", null, $HideKeyboard);
			
			_ожидание_результата();
			
		}
		
	}else $bot->deleteMessage($chat_id, $message_id);
	

}
	

  
  




?>
