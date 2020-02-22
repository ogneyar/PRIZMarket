<?
// Если клиент шлёт сразу группу файлов
if ($media_group_id) {

	_запись_в_таблицу_медиагрупа();	

}

if (strpos($text, ":")!==false) {

	$команда = strstr($text, ':', true);	
	
	$id = substr(strrchr($text, ":"), 1);
	
	if ($команда == 'лоты') {
	
		if ($id) {
		
			//_список_всех_лотов($id);
			_вывод_списка_лотов("покажи", $id);
		
		}else {
			
			//_список_всех_лотов();
			_вывод_списка_лотов("покажи", null, true);
			
		}		
		
	}

}

if ($reply_to_message && $chat_id == $admin_group) {
	
	if (!$reply_caption) $reply_caption = $reply_text;
	
	$номер_строки = strpos($reply_caption, '@');
	
	if ($номер_строки >= 0) {
		
		$строка = strstr($reply_caption, '@');

		$есть_ли_энтр = strpos($строка, 10);
		
		if ($есть_ли_энтр) {
			
			$юзер_нейм = strstr($строка, 10, true);
			
		}else {
			
                      $есть_ли_пробел = strpos($строка, ' ');
		
		      if ($есть_ли_пробел) {
			
			      $юзер_нейм = strstr($строка, ' ', true);
			
		      }else {
			
			      $юзер_нейм = $строка;
			
		      }


		}


		
		//$bot->sendMessage($master, $юзер_нейм);
		
		$id_client = _дай_айди($юзер_нейм);
		
		$главное_меню = "\n\n/start 👈🏻 в главное меню!";
		
		$результат = $bot->sendMessage($id_client, $text.$главное_меню);
		
		if ($результат) {
			
			$bot->sendMessage($chat_id, "Отправил.", null, null, $message_id);
			
		}
		
	}

}elseif ($text=='Редактор лотов') {

	$админ = $bot->this_admin($table_users);
	
	if ($админ) {
	
		_ожидание_ввода('редактор_лотов', 'старт');
		
		$ReplyKey = [
			'keyboard' => [
				[			
					[
						'text' => "Отмена ввода"
					]
				]
			],
			'resize_keyboard' => true,
			'selective' => true,
		];
		
		$reply = "Пришлите мне номер лота.";
		
		$bot->sendMessage($chat_id, $reply, null, $ReplyKey);
	
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
		
		}elseif ($result['last'] == 'хорошо') {
		
			_очистка_таблицы_ожидание();			
			
		}elseif ($result['last'] == 'старт') {
		
			_очистка_таблицы_ожидание();
			
			_start_AvtoZakazBota();
			
		}
		
	}else _start_AvtoZakazBota();
	

}else { 
	
	$result = _ожидание_ввода();
	
	if ($result) {
		
		if ($result['ojidanie'] == 'редактор_лотов') {			
			
			if ($text) {
				
				_редактор_лотов($text);
				
				_очистка_таблицы_ожидание();		
				
			}
			
		}elseif ($result['ojidanie'] == 'название_редакт') {
			
			$айди_заказа = $result['last'];
			
			if ($text) {
				
				$text = str_replace("'", "\'", $text);
				$text = str_replace("`", "\`", $text);
				
				_редакт_таблицы_маркет($айди_заказа, 'nazvanie', $text);
				
				_очистка_таблицы_ожидание();
				
				$bot->sendMessage($chat_id, "Принял. Заменил.", null, $HideKeyboard);	

				$bot->sendMessage($chat_id, $text);			
				
			}			

			
		}elseif ($result['ojidanie'] == 'ссылку_редакт') {
			
			$айди_заказа = $result['last'];
			
			if ($text) {
			
				_редакт_таблицы_маркет($айди_заказа, 'url_nazv', $text);
				
				_очистка_таблицы_ожидание();
				
				$bot->sendMessage($chat_id, "Принял. Заменил.", null, $HideKeyboard);	

				$bot->sendMessage($chat_id, $text);			
				
			}			

			
		}elseif ($result['ojidanie'] == 'хештеги_редакт') {
			
			$айди_заказа = $result['last'];
			
			if ($text) {
			
				_редакт_таблицы_маркет($айди_заказа, 'gorod', $text);
				
				_очистка_таблицы_ожидание();
				
				$bot->sendMessage($chat_id, "Принял. Заменил.", null, $HideKeyboard);	

				$bot->sendMessage($chat_id, $text);			
				
			}			

			
		}elseif ($result['ojidanie'] == 'подробности_редакт') {
			
			$айди_заказа = $result['last'];
			
			if ($text) {
				
				$text = str_replace("'", "\'", $text);
				$text = str_replace("`", "\`", $text);
			
				_редакт_таблицы_маркет($айди_заказа, 'podrobno', $text);
				
				_очистка_таблицы_ожидание();
				
				$bot->sendMessage($chat_id, "Принял. Заменил.", null, $HideKeyboard);	

				$bot->sendMessage($chat_id, $text);			
				
			}			

			
		}elseif ($result['ojidanie'] == 'фото_редакт') {
			
			$айди_заказа = $result['last'];
			
			if ($photo) {
			
				_редакт_таблицы_маркет($айди_заказа, 'file_id', $file_id);
				
				_очистка_таблицы_ожидание();
				
				$bot->sendMessage($chat_id, "Принял. Заменил.", null, $HideKeyboard);		

				$Объект_файла = $bot->getFile($file_id);		
		
				$ссыль_на_файл = $bot->fileUrl . $bot->token;	
					
				$ссыль = $ссыль_на_файл . "/" . $Объект_файла['file_path'];		
					
				$результат = $imgBB->upload($ссыль);					
					
				if ($результат) {		
						
					$imgBB_url = $результат['url'];		

					_редакт_таблицы_маркет($айди_заказа, 'url_tgraph', $imgBB_url);
					
				}else throw new Exception("Не смог сделать редакт imgBB_url");			

				_редакт_таблицы_маркет($айди_заказа, 'format_file', 'фото');
				
			}

			
		}elseif ($result['ojidanie'] == 'замена_названия') {
			
			$айди_клиента = $result['last'];
			
			if ($text) {
				
				$text = str_replace("'", "\'", $text);
				$text = str_replace("`", "\`", $text);
			
				_запись_в_таблицу_маркет($айди_клиента, 'nazvanie', $text);
				
				_очистка_таблицы_ожидание();
				
				$bot->sendMessage($chat_id, "Принял. Заменил.", null, $HideKeyboard);	

				$bot->sendMessage($chat_id, $text);			
				
			}			

			
		}elseif ($result['ojidanie'] == 'замена_ссылки') {
			
			$айди_клиента = $result['last'];
			
			if ($text) {
			
				_запись_в_таблицу_маркет($айди_клиента, 'url_nazv', $text);
				
				_очистка_таблицы_ожидание();
				
				$bot->sendMessage($chat_id, "Принял. Заменил.", null, $HideKeyboard);	

				$bot->sendMessage($chat_id, $text);			
				
			}			

			
		}elseif ($result['ojidanie'] == 'замена_хештегов') {
			
			$айди_клиента = $result['last'];
			
			if ($text) {
			
				_запись_в_таблицу_маркет($айди_клиента, 'gorod', $text);
				
				_очистка_таблицы_ожидание();
				
				$bot->sendMessage($chat_id, "Принял. Заменил.", null, $HideKeyboard);				
				
				$bot->sendMessage($chat_id, $text);		
				
			}			

			
		}elseif ($result['ojidanie'] == 'замена_подробностей') {
			
			$айди_клиента = $result['last'];
			
			if ($text) {
				
				$text = str_replace("'", "\'", $text);
				$text = str_replace("`", "\`", $text);
			
				_запись_в_таблицу_маркет($айди_клиента, 'podrobno', $text);
				
				_очистка_таблицы_ожидание();
				
				$bot->sendMessage($chat_id, "Принял. Заменил.", null, $HideKeyboard);				
				
				$bot->sendMessage($chat_id, $text);		
			
			}			

			
		}elseif ($result['ojidanie'] == 'замена_фото') {
			
			$айди_клиента = $result['last'];
			
			if ($photo) {
			
				_запись_в_таблицу_маркет($айди_клиента, 'file_id', $file_id);
				
				_очистка_таблицы_ожидание();
				
				$bot->sendMessage($chat_id, "Принял. Заменил.", null, $HideKeyboard);				
				
				$Объект_файла = $bot->getFile($file_id);		
		
				$ссыль_на_файл = $bot->fileUrl . $bot->token;	
					
				$ссыль = $ссыль_на_файл . "/" . $Объект_файла['file_path'];		
					
				$результат = $imgBB->upload($ссыль);					
					
				if ($результат) {		
						
					$imgBB_url = $результат['url'];		

					_запись_в_таблицу_маркет($айди_клиента, 'url_tgraph', $imgBB_url);
					
				}else throw new Exception("Не смог сделать imgBB_url");					
						
			}			

			
		}elseif ($result['ojidanie'] == 'nazvanie') {
			
			if ($text) {				
				
				//$text = mysqli_real_escape_string($text);
				
				if (strlen($text) > 60) {
				
					$bot->sendMessage($chat_id, "Слишком длинное название.\nНапишите название, около 30 символов.");
					
					exit('ok');
				}
				
				$text = str_replace("'", "\'", $text);
				$text = str_replace('"', '\"', $text);
				$text = str_replace(';', '', $text);
				$text = str_replace('*', 'х', $text);
				$text = str_replace('%', '', $text);
				$text = str_replace('`', '', $text);				
				$text = str_replace('&', '', $text);
				$text = str_replace('$', '', $text);
				$text = str_replace('^', '', $text);
				
				$text = str_replace('_', ' ', $text);
				
				$text = str_replace('\\', '', $text);
				$text = str_replace('|', '', $text);
				$text = str_replace('/', '', $text);
				$text = str_replace('<', '', $text);
				$text = str_replace('>', '', $text);
				$text = str_replace('~', '', $text);
								
				_запись_в_таблицу_маркет($from_id, 'nazvanie', $text);
			
				_очистка_таблицы_ожидание();
				
				$bot->sendMessage($chat_id, "Принял.", null, $HideKeyboard);
				
				_ссылка_в_названии();			
				
			}else $bot->deleteMessage($chat_id, $message_id);			
			
		}elseif ($result['ojidanie'] == 'url_nazv') {
			
			if ($text) {						
				
				//$text = mysqli_real_escape_string($text);
				
				//надо проверить есть ли в тексте http://
				_запись_в_таблицу_маркет($from_id, 'url_nazv', $text);			
			
				_очистка_таблицы_ожидание();
				
				$bot->sendMessage($chat_id, "Принял.", null, $HideKeyboard);
				
				_выбор_категории();
				
				//_выбор_валюты();
				
			}else $bot->deleteMessage($chat_id, $message_id);			
			
		}elseif ($result['ojidanie'] == 'gorod') {
			
			if ($text) {
								
				$text = str_replace('|', '', $text);
				$text = str_replace('/', '', $text);
				$text = str_replace('<', '', $text);
				$text = str_replace('>', '', $text);
				$text = str_replace('~', '', $text);
				$text = str_replace(':', '', $text);				
				$text = str_replace("'", "", $text);
				$text = str_replace('"', '', $text);
				$text = str_replace(';', '', $text);
				$text = str_replace('*', '', $text);
				$text = str_replace('%', '', $text);
				$text = str_replace('`', '', $text);
				$text = str_replace('?', '', $text);
				$text = str_replace('&', '', $text);
				$text = str_replace('$', '', $text);
				$text = str_replace('^', '', $text);
				$text = str_replace('\\', '', $text);
				//$text = str_replace('_', '\_', $text);
				
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
					
					$bot->sendMessage($chat_id, "Пришлите все фото сразу, не по одному!\n(При отправке выберите: 'отправить альбом')");
					
					$bot->deleteMessage($chat_id, $message_id);	
					
				}
				
			}else $bot->deleteMessage($chat_id, $message_id);	
			
			
		}elseif ($result['ojidanie'] == 'podrobno') {
		
			if ($text) {
				
				$количество = strlen($text);
				
				if ($количество < 200) {
					
					$bot->sendMessage($chat_id, "Для 'подробностей' слишком мало текста. Повторите ввод.");
					
					exit('ok');
					
				}elseif ($количество > 4000) {
					
					$bot->sendMessage($chat_id, "Для 'подробностей' слишком много текста. Повторите ввод.");
					
					exit('ok');
				
				}
				
				$text = str_replace("'", "\'", $text);
				$text = str_replace("`", "\`", $text);
				
				$text = str_replace('"', '\"', $text);
			
				$text = str_replace('*', 'х', $text);
				
				$text = str_replace('[', '(', $text);
				$text = str_replace(']', ')', $text);
				
				_запись_в_таблицу_маркет($from_id, 'podrobno', $text);				
				
				_очистка_таблицы_ожидание();
				
				$bot->sendMessage($chat_id, "Принял.", null, $HideKeyboard);
			
				_предпросмотр_лота();				
				
			}else $bot->deleteMessage($chat_id, $message_id);		
			
		}
		
	}elseif ($chat_type == 'private') $bot->deleteMessage($chat_id, $message_id);
	
}
	




?>
