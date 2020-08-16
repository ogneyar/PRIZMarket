<?

/* Список всех функций:
**
** _дай_имя
** _дай_дату
** _дай_емаил
** _дай_связь_сайт
** _дай_номер_заказа
** _отправка_лота_админам_с_сайта
** _запись_в_маркет_с_сайта
** _вывод_на_каналы_с_сайта
** _отказать_с_сайта
** 
** _есть_ли_запись
*
* _вывод_списка_лотов_клиента
**
*/


function _дай_имя($дата) {	
	global $mysqli;
	$ответ = false;
	$запрос = "SELECT login FROM site_users WHERE vremya='{$дата}'";
	$результат = $mysqli->query($запрос);
	if ($результат) {
		if ($результат->num_rows == 1) {		
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);
			$ответ = $результМассив[0]['login'];
		}
	}
	return $ответ;
}

function _дай_дату($логин) {	
	global $mysqli;
	$ответ = false;
	$запрос = "SELECT vremya FROM site_users WHERE login='{$логин}'";
	$результат = $mysqli->query($запрос);
	if ($результат) {
		if ($результат->num_rows == 1) {		
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);
			$ответ = $результМассив[0]['vremya'];
		}
	}
	return $ответ;
}

function _дай_емаил($имя_клиента) {	
	global $mysqli;
	$ответ = false;
	$запрос = "SELECT email FROM site_users WHERE login='{$имя_клиента}'";
	$результат = $mysqli->query($запрос);
	if ($результат) {
		if ($результат->num_rows == 1) {		
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);
			$ответ = $результМассив[0]['email'];
		}
	}
	return $ответ;
}

function _дай_связь_сайт($имя_клиента) {	
	global $mysqli;
	$ответ = false;
	$запрос = "SELECT svyazi, svyazi_data FROM site_users WHERE login='{$имя_клиента}'";
	$результат = $mysqli->query($запрос);
	if ($результат) {
		if ($результат->num_rows == 1) {		
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);
			$связь = $результМассив[0]['svyazi'];
			$данные = $результМассив[0]['svyazi_data'];
			if ($связь == 'Telegram') {
				if (strpos($данные, "@")!==false) {		
					$ник = substr(strrchr($данные, "@"), 1);
					$ответ = "https://teleg.link/{$ник}";
				}else $ответ = "https://teleg.link/{$данные}";
			}elseif ($связь == 'WhatsApp') {
				if (strpos($данные, "+")!==false) {		
					$ник = substr(strrchr($данные, "+"), 1);
					$ответ = "https://wa.me/{$ник}";
				}else $ответ = "https://wa.me/{$данные}";
			}elseif ($связь == 'Wiber') {
				if (strpos($данные, "+")!==false) {		
					$ник = substr(strrchr($данные, "+"), 1);
					$ответ = "https://wb.me/{$ник}";
				}else $ответ = "https://wb.me/{$данные}";
			}
		}
	}
	return $ответ;
}

function _дай_номер_заказа($имя_клиента) {	
	global $mysqli;
	$ответ = false;
	$запрос = "SELECT id_zakaz FROM avtozakaz_pzmarket WHERE id_client='7' AND username='{$имя_клиента}' AND status=''";
	$результат = $mysqli->query($запрос);
	if ($результат) {
		if ($результат->num_rows == 1) {		
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);
			$ответ = $результМассив[0]['id_zakaz'];
		}
	}
	return $ответ;
}


// отправка лота администрации на проверку и редактирование
function _отправка_лота_админам_с_сайта() {	
	global $table_market, $bot, $mysqli, $admin_group, $логин;
	
	$дата_токен = _дай_дату($логин);
	
	$id = "7.".$дата_токен;
	$кнопки = [ [ [ 'text' => 'Опубликовать',
		'callback_data' => 'опубликовать:'.$id ] ], ];
	
	$кнопки = array_merge($кнопки, [		
		[ [ 'text' => 'PRIZMarket доверяет',
			'callback_data' => 'доверяет:'.$id ] ],
		[ [ 'text' => 'PRIZMarket НЕ доверяет',
			'callback_data' => 'не_доверяет:'.$id ] ],
		[ [ 'text' => 'Редактировать название',
			'callback_data' => 'редактировать_название:'.$id ] ],
	]);				
	$запрос = "SELECT * FROM {$table_market} WHERE id_client='7' AND username='{$логин}' AND status=''";
	$результат = $mysqli->query($запрос);	
	if ($результат) {		
		if ($результат->num_rows == 1) {		
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);			
			foreach ($результМассив as $строка) {			
			
				$название = $строка['nazvanie'];
				if ($строка['url_nazv']) {					
					$ссыль_в_названии = $строка['url_nazv'];						
					$название_для_подробностей = "[{$название}]({$ссыль_в_названии})";
					$кнопки = array_merge($кнопки, [
						[ [ 'text' => 'Редактировать ссылку',
							'callback_data' => 'редактировать_ссылку:'.$id ] ],
					]);						
				}else $название_для_подробностей = str_replace('_', '\_', $название);	
				$кнопки = array_merge($кнопки, [
					[ [ 'text' => 'Редактировать хештеги',
						'callback_data' => 'редактировать_хештеги:'.$id ] ],
					[ [ 'text' => 'Редактировать подробности',
						'callback_data' => 'редактировать_подробности:'.$id ] ],
					[ [ 'text' => 'Редактировать фото',
						'callback_data' => 'редактировать_фото:'.$id ] ],	
				]);	
				
				$кнопки = array_merge($кнопки, [ [ [ 'text' => 'ОТКАЗАТЬ',
					'callback_data' => 'отказать:'.$id ] ],]);
				
				$inLine = [ 'inline_keyboard' => $кнопки ];				
				$куплю_или_продам = $строка['kuplu_prodam'];						
				$валюта = $строка['valuta'];				
				$хештеги_города = $строка['gorod'];		
				
				$связь = _дай_связь_сайт($логин);
				
				$фото_с_амазон = $строка['url_tgraph'];
				$категория = $строка['otdel'];								
				$подробности = $строка['podrobno'];

				$подробности = str_replace('_', '\_', $подробности);
				
				$хештеги = "{$куплю_или_продам}\n\n{$категория}\n▪️";			
				$хештеги = str_replace('_', '\_', $хештеги);				
				$текст = "\n▪️{$валюта}\n▪️{$хештеги_города}\n▪️";				
				$текст = str_replace('_', '\_', $текст);	
				$текст .= "[{$логин}]({$связь})\n\n{$подробности}";
      				
				if ($ссыль_в_названии) {					
					$ссыль_в_названии = str_replace('_', '\_', $ссыль_в_названии);		
					$текст = "{$хештеги}{$название_для_подробностей}\n({$ссыль_в_названии}){$текст}";		
				}else $текст = "{$хештеги}{$название_для_подробностей}{$текст}";
				
				$реплика = "[_________]({$фото_с_амазон}) Лот с сайта https://PRIZMarket.ru\n{$текст}";
				$КаналИнфо = $bot->sendMessage($admin_group, $реплика, markdown, $inLine);			
				
				if (!$КаналИнфо) {
					echo "Ошибка! Не смог опубликовать лот в РАЙминке";
					exit;
				}
			}					
		}else echo "<br><br>Или нет заказа или больше одного.. (_отправка_лота_админам)";	
	}else echo "<br><br>Нет такого заказа.. (_отправка_лота_админам)";	
}

// Функция для записи данных в таблицу маркет
function _запись_в_маркет_с_сайта($имя_клиента = null, $имя_столбца = null, $действие = null) {
	global $table_market, $mysqli;		
	if (strpos($имя_клиента, ".")!==false) {
		$дата_токен = substr(strrchr($имя_клиента, "."), 1);
		$имя_клиента = _дай_имя($дата_токен);
	}	
	$query ="UPDATE {$table_market} SET {$имя_столбца}='{$действие}' WHERE id_client='7' AND username='{$имя_клиента}' AND status=''";	
	$result = $mysqli->query($query);			
	if (!$result) throw new Exception("Не смог сделать запись в таблицу {$table_market} (_запись_в_маркет_с_сайта)");	
}


// вывод на канал подробности уже готового лота (кнопка у админов ОПУБЛИКОВАТЬ)
function _вывод_на_каналы_с_сайта($команда) {
	global $table_market, $bot, $callback_query_id, $s3, $aws_bucket, $chat_id, $mysqli, $imgBB, $channel_podrobno, $channel_market;
	global $таблица_медиагруппа, $channel_media_market, $master, $tester, $message_id, $admin_group, $три_часа;
	global $smtp_server, $smtp_port, $smtp_login, $smtp_pass, $channel_info;	
	_очистка_таблицы_ожидание();
	
	$bot->answerCallbackQuery($callback_query_id, "Ожидайте! Идёт загрузка фото, отправка письма на email и ещё несколько разных операций, это длительный процесс..", true);
	
	$дата_токен = substr(strrchr($команда, "."), 1);
	$имя_клиента = _дай_имя($дата_токен);	

	$запрос = "SELECT * FROM {$table_market} WHERE id_client='7' AND username='{$имя_клиента}' AND status=''";
	$результат = $mysqli->query($запрос);
	if ($результат) {	
		if ($результат->num_rows == 1) {		
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);			
			foreach ($результМассив as $строка) {					
				$файлАйди = $строка['file_id'];
				$формат_файла = $строка['format_file'];				
				$название = $строка['nazvanie'];				
				if ($строка['url_nazv']) {				
					$ссыль_в_названии = $строка['url_nazv'];						
					$название_для_подробностей = "[{$название}]({$ссыль_в_названии})";
				}else $название_для_подробностей = str_replace('_', '\_', $название);
				$куплю_или_продам = $строка['kuplu_prodam'];
				$валюта = $строка['valuta'];				
				$хештеги_города = $строка['gorod'];
				$доверие = $строка['doverie'];
				$категория = $строка['otdel'];				
				$подробности = $строка['podrobno'];							
				$хештеги = "{$куплю_или_продам}\n\n{$категория}\n▪️";				
				$хештеги = str_replace('_', '\_', $хештеги);		

				$ссылка_на_клиента = $строка['url_info_bot']; // https://wa.me/ххххххххххх				
				if (!$ссылка_на_клиента) $ссылка_на_клиента = "https://prizmarket.ru";
				
				$текст = "\n▪️{$валюта}\n▪️{$хештеги_города}\n▪️";				
				$текст = str_replace('_', '\_', $текст);
				$текст .= "[{$имя_клиента}]({$ссылка_на_клиента})";			
	
				$количество = substr_count($подробности, '[');				
				if ($количество == 0) {					
					$подробности = str_replace('_', '\_', $подробности);
				}							
				$текст .= "\n\n{$подробности}"; 								
				$текст = "{$хештеги}{$название_для_подробностей}{$текст}";	
				
				//$uniqid = $строка['id_zakaz'];	
				
				$ссылка_на_фото = $строка['url_tgraph'];
								
				if ($ссылка_на_фото) {
					if ($tester == 'да') {
						$реплика = "Эта заявка с - www.prizmarket.online\n[_________]({$ссылка_на_фото})\n{$текст}";
					}else $реплика = "Эта заявка с - www.prizmarket.ru\n[_________]({$ссылка_на_фото})\n{$текст}";
				}else $реплика = $текст;	
				
				$кнопки = [
					[
						[ 'text' => 'КЛИЕНТ', 'url' => $ссылка_на_клиента ],
						[ 'text' => 'ГАРАНТ', 'url' => 'https://t.me/podrobno_s_PZP/1044' ]
					]
				];				
			
				$кнопки = array_merge($кнопки, [
					[
						[   'text' => 'INSTAGRAM PRIZMarket',
							'url' => 'https://www.instagram.com/prizm_market_inst' ],
						[ 	'text' => 'PZMarket bot',
							'url' => 'https://t.me/Prizm_market_bot' ]
					],
					[
						[   'text' => 'Заказать пост', 
							'url' => 'https://t.me/Zakaz_prizm_bot' ],
						[ 	'text' => 'Канал PRIZMarket',
							'url' => 'https://t.me/prizm_market/' ]
					],
					[
						[   'text' => 'ICQ new PRIZMarket', 
							'url' => 'https://icq.im/prizmarket' ],
						[ 	'text' => '❗️САЙТ PRIZMarket❗️',
							'url' => 'https://prizmarket.ru' ]
					]
				]);				
				$inLine = ['inline_keyboard' => $кнопки];						
				$КаналИнфо = $bot->sendMessage($channel_podrobno, $реплика, markdown, $inLine);				
			}			
			if ($КаналИнфо) {
				$id_zakaz = $КаналИнфо['message_id'];				
				_запись_в_маркет_с_сайта($имя_клиента, 'id_zakaz', $id_zakaz);
								
				$array = [ 'id_zakaz' => $id_zakaz, 'file' => $ссылка_на_фото ];		
				// инфа о том с какого сайта (тестового или оригинала) идёт посылка
				if ($tester == 'да') $array = array_merge($array, [ 'tester' => $tester ]);		
				// отправка madeLine фото для публикации её в телеге
				$ch = curl_init("http://f0430377.xsph.ru"."?".http_build_query($array));
				//curl_setopt($ch, CURLOPT_POST, 1);
				//curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($array)); 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_HEADER, false);
				$html = curl_exec($ch);
				curl_close($ch);	
							
				
				$ссыль_на_подробности = "https://t.me/{$КаналИнфо['chat']['username']}/{$id_zakaz}";			
				_запись_в_маркет_с_сайта($имя_клиента, 'url_podrobno', $ссыль_на_подробности);
				
				if (!$ссыль_в_названии) {					
					_запись_в_маркет_с_сайта($имя_клиента, 'url_nazv', $ссыль_на_подробности);
					$ссыль_в_названии = $ссыль_на_подробности;						
				}					
				
				_запись_в_маркет_с_сайта($имя_клиента, 'status', "одобрен");				
				$время = _ожидание_публикации($id_zakaz);
				$время_публикации = date("H:i", $время);				
				// КОМУ
				$емаил = _дай_емаил($имя_клиента);				
				// ЧТО
				$сообщение = "&nbsp;&nbsp;{$имя_клиента}, Вашему лоту присвоен номер {$id_zakaz}.<br>Публикация в {$время_публикации} мск.<br><br>&nbsp;&nbsp;На это письмо отвечать не нужно.";				
				// ОТПРАВИТЬ
				include 'phpmailer.php';			
				$сообщение_райминам = "{$имя_клиента} (сайт) лот {$id_zakaz}\nПубликация в {$время_публикации} мск";	
				$bot->sendMessage($chat_id, $сообщение_райминам);	
                                $bot->sendMessage($channel_info, "?");
			}else throw new Exception("Не отправился лот на канал Подробности.. (_вывод_на_каналы_с_сайта)");	
		}else throw new Exception("Или нет заказа или больше одного.. (_вывод_на_каналы_с_сайта)");				
	}else throw new Exception("Нет такого заказа.. (_вывод_на_каналы_с_сайта)");	
	$inLine = [ 'inline_keyboard' => [
		[ [ 'text' => 'Опубликованно в подробностях', 'url' => $ссыль_на_подробности ] ]
	] ];	
	$bot->editMessageReplyMarkup($chat_id, $message_id, null, $inLine);
}

// Если клиенту отказанно в публикации лота (кнопка у админов ОТКАЗ)
function _отказать_с_сайта($имя_клиента) {
	global $bot, $s3, $aws_bucket, $admin_group, $master, $chat_id, $message_id, $mysqli, $table_market;	
	global $smtp_server, $smtp_port, $smtp_login, $smtp_pass;	
	
	$id = '7';
	if (strpos($имя_клиента, ".")!==false) {
		$id = strstr($имя_клиента, '.', true);				
		$дата_токен = substr(strrchr($имя_клиента, "."), 1);
		$имя_клиента = _дай_имя($дата_токен);
	}
	
	$запрос = "SELECT url_tgraph FROM {$table_market} WHERE id_client='7' AND username='{$имя_клиента}' AND status=''";	
	if ($результат = $mysqli->query($запрос)) {		
		if ($результат->num_rows == 1) {		
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);			
			$ссылка = $результМассив[0]['url_tgraph'];
			if ($ссылка) {				
				
				$файл = substr(strrchr($ссылка, "/"), 1);
				
				$array = [ 'file' => $файл ];		
				
				$ch = curl_init("http://f0430377.xsph.ru/deleteimage.php");
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($array)); 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_HEADER, false);
				$html = curl_exec($ch);
				curl_close($ch);					
				
			}
		}		
	}
	
	$query = "DELETE FROM ".$table_market." WHERE id_client='{$id}' AND username='{$имя_клиента}' AND status=''";
	if ($mysqli->query($query)) {		
		$inLine = [ 'inline_keyboard' => [
				[ [ 'text' => 'Отказанно', 'callback_data' => 'отказанно' ] ] 
		] ];		
		$bot->editMessageReplyMarkup($chat_id, $message_id, null, $inLine);
	}else throw new Exception("Не смог удалить запись в таблице {$table_market} (_отказать)");	
	// КОМУ
	$емаил = _дай_емаил($имя_клиента);				
	// ЧТО
	$сообщение = "&nbsp;&nbsp;{$имя_клиента}, Вам отказанно. Читайте правила.<br><br>&nbsp;&nbsp;На это письмо отвечать не нужно.";				
	// ОТПРАВИТЬ
	include 'phpmailer.php';
}

function _есть_ли_запись($логин, $запись) {	
	global $mysqli;
	$ответ = false;
	$запрос = "SELECT {$запись} FROM avtozakaz_pzmarket WHERE username='{$логин}' AND id_client='7' AND status=''";
	$результат = $mysqli->query($запрос);
	if ($результат) {
		if ($результат->num_rows == 1) {		
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);
			if ($результМассив[0][$запись]) $ответ = true;
		}
	}
	return $ответ;
}


/*
** Вывод заданной таблицы на экран	
*/
function _вывод_списка_лотов_клиента($таблица, $имя_клиента = null, $max_kol_s = 4000) { 

	global $chat_id, $mysqli, $master, $bot;
	
	if ($имя_клиента) {
		$query = "SELECT * FROM {$таблица} WHERE username='{$имя_клиента}' AND id_client='7'";
	}else $query = "SELECT * FROM {$таблица} WHERE id_client='7'";
		
	if ($result = $mysqli->query($query)) {		
		$reply="Таблица {$таблица}:\n";			
		if($result->num_rows>0){			
			$arrayResult = $result->fetch_all();
			foreach($arrayResult as $row){
				foreach($row as $stroka) $reply.= "| ".$stroka." ";
				$reply.="|\n";							
			}		
			$bot->output($reply, $max_kol_s);
		}else $bot->sendMessage($chat_id, "пуста таблица ".
			" \xF0\x9F\xA4\xB7\xE2\x80\x8D\xE2\x99\x82\xEF\xB8\x8F");
	}else throw new Exception("Не смог получить записи в таблице {$таблица} (_вывод_списка_лотов_клиента)");

	return true;
	
}


?>
