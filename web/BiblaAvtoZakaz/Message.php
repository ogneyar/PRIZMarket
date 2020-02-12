<?
// Если клиент шлёт сразу группу файлов
if ($media_group_id) {

	_запись_в_таблицу_медиагрупа();	

}

if ($reply_to_message && $chat_id == $admin_group) {
	
	$номер_строки = strpos($reply_caption, '@');
	
	if ($номер_строки) {
		
		$строка = strstr($reply_caption, '@');
		
		$есть_ли_энтр = strpos($строка, 10);
		
		if ($есть_ли_энтр) {
			
			$юзер_нейм = strstr($строка, 10, true);
			
		}else {
			
			$юзер_нейм = $строка;
			
		}
		
		//$bot->sendMessage($master, $юзер_нейм);
		
		$id_client = _дай_айди($юзер_нейм);
		
		$bot->sendMessage($id_client, $reply_text);
		
	}

}elseif ($text=='Отмена ввода') {

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
		
		}elseif ($result['last'] == 'foto_album') {
		
			_очистка_таблицы_ожидание();
			
			_нужен_ли_фотоальбом();
		
		}
		
	}else _start_AvtoZakazBota();
	

}else { 
	
	$result = _ожидание_ввода();
	
	if ($result) {
		
		if ($result['ojidanie'] == 'nazvanie') {
			
			if ($text) {
				
				_запись_в_таблицу_маркет($from_id, 'nazvanie', $text);
			
				_очистка_таблицы_ожидание();
				
				$bot->sendMessage($chat_id, "Принял.", null, $HideKeyboard);
				
				_ссылка_в_названии();			
				
			}else $bot->deleteMessage($chat_id, $message_id);			
			
		}elseif ($result['ojidanie'] == 'url_nazv') {
			
			if ($text) {				
				
				//надо проверить есть ли в тексте http://
				_запись_в_таблицу_маркет($from_id, 'url_nazv', $text);			
			
				_очистка_таблицы_ожидание();
				
				$bot->sendMessage($chat_id, "Принял.", null, $HideKeyboard);
				
				_выбор_категории();
				
				//_выбор_валюты();
				
			}else $bot->deleteMessage($chat_id, $message_id);			
			
		}elseif ($result['ojidanie'] == 'gorod') {
			
			if ($text) {
			
				$количество = substr_count($text, '#');
				
				if ($количество == 0) {
					
					$bot->sendMessage($chat_id, "Повторите ввод, но только теперь, обязательно поставьте хештег - #.");
					
					$bot->deleteMessage($chat_id, $message_id);		
					
				}elseif ($количество>3) {
					
					$bot->sendMessage($chat_id, "Повторите ввод, но, не больше трёх - #.");
					
					$bot->deleteMessage($chat_id, $message_id);		
				
				}else {
					
					// тут можно по entities достать только хештеги
					
					_запись_в_таблицу_маркет($from_id, 'gorod', $text);			
				
					_очистка_таблицы_ожидание();
					
					$bot->sendMessage($chat_id, "Принял.", null, $HideKeyboard);
					
					_отправьте_файл();
				
				}
				
			}else $bot->deleteMessage($chat_id, $message_id);			
			
		}elseif ($result['ojidanie'] == 'format_file') {			
			
			if ($photo||$video) {

				if ($video) {
					
					if ($file_size>'5242880') {
						
						$bot->sendMessage($chat_id, "Повторите ввод, а то Ваш файл размером больше 5 МБ, сократите его немного.");
					
						$bot->deleteMessage($chat_id, $message_id);
						
						exit('ok');
						
					}					
					
				}
			
				_запись_в_таблицу_маркет($from_id, 'format_file', $формат_файла);

				_запись_в_таблицу_маркет($from_id, 'file_id', $file_id);
				
				_очистка_таблицы_ожидание();
				
				if ($media_group_id) {
					
					$реплика = "Принял только ЭТОТ 👆🏻 файл.";
				
				}else $реплика = "Принял.";
				
				$bot->sendMessage($chat_id, $реплика, null, $HideKeyboard);
				
				_нужен_ли_фотоальбом();
			
			}else $bot->deleteMessage($chat_id, $message_id);
			
		}elseif ($result['ojidanie'] == 'foto_album') {						
			
			if ($формат_файла) {
			
				if ($media_group_id) {
				
					_очистка_таблицы_ожидание();

					//_запись_в_таблицу_медиагрупа();					
					
					$bot->sendMessage($chat_id, "Принял, ВСЕ.", null, $HideKeyboard);
					
					_опишите_подробно();
				
				}else {
					
					$bot->sendMessage($chat_id, "Пришлите все фото сразу, не по одному!!!");
					
					$bot->deleteMessage($chat_id, $message_id);	
					
				}
				
			}else $bot->deleteMessage($chat_id, $message_id);	
			
			
		}elseif ($result['ojidanie'] == 'podrobno') {
		
			if ($text) {
				
				_запись_в_таблицу_маркет($from_id, 'podrobno', $text);

				_очистка_таблицы_ожидание();
				
				$bot->sendMessage($chat_id, "Принял.", null, $HideKeyboard);
				
				//_вывод_лота_на_каналы();
				
				_отправка_лота_админам();
				
				_ожидание_результата();
				
				_отправка_сообщений_инфоботу();
				
			}else $bot->deleteMessage($chat_id, $message_id);		
			
		}
		
	}elseif ($chat_type == 'private') $bot->deleteMessage($chat_id, $message_id);
	

}
	

  
  




?>
