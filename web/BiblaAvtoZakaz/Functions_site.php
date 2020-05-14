<?

/* Список всех функций:
**
** _дай_емаил
** _дай_связь
** _дай_номер_заказа
** _отправка_лота_админам  // отправка из сайта
** _запись_в_маркет_с_сайта
** _вывод_на_каналы_с_сайта
** _отказать_с_сайта
**
**
*/

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

function _дай_связь($имя_клиента) {	
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
	
	$запрос = "SELECT * FROM {$table_market} WHERE id_client='7' AND username='{$логин}' AND status=''";
	
	$id = "7.".$логин;
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
				
				$юзера_имя = $строка['username']; // это логин
				
				$фото_с_амазон = $строка['url_tgraph'];
				$категория = $строка['otdel'];								
				$подробности = $строка['podrobno'];				
				$хештеги = "{$куплю_или_продам}\n\n{$категория}\n▪️";			
				$хештеги = str_replace('_', '\_', $хештеги);				
				$текст = "\n▪️{$валюта}\n▪️{$хештеги_города}\n▪️{$юзера_имя}\n\n{$подробности}";				
				$текст = str_replace('_', '\_', $текст);								
				if ($ссыль_в_названии) {					
					$ссыль_в_названии = str_replace('_', '\_', $ссыль_в_названии);		
					$текст = "{$хештеги}{$название_для_подробностей}\n({$ссыль_в_названии}){$текст}";		
				}else $текст = "{$хештеги}{$название_для_подробностей}{$текст}";
				
				$реплика = "[_________]({$фото_с_амазон}) Лот с сайта https://PRIZMarket.ru\n{$текст}";
				$КаналИнфо = $bot->sendMessage($admin_group, $реплика, markdown, $inLine);			
				
				if (!$КаналИнфо) echo "<br><br>Не смог опубликовать лот в админке";				
			}					
		}else echo "<br><br>Или нет заказа или больше одного.. (_отправка_лота_админам)";	
	}else echo "<br><br>Нет такого заказа.. (_отправка_лота_админам)";	
}

// Функция для записи данных в таблицу маркет
function _запись_в_маркет_с_сайта($имя_клиента = null, $имя_столбца = null, $действие = null) {
	global $table_market, $mysqli;	
	
	if (strpos($имя_клиента, ".")!==false) {
		$id = strstr($имя_клиента, '.', true);		
		$имя_клиента = substr(strrchr($имя_клиента, "."), 1);	
	}
	
	$query ="UPDATE {$table_market} SET {$имя_столбца}='{$действие}' WHERE id_client='{$id}' AND username='{$имя_клиента}' AND status=''";				
	
	$result = $mysqli->query($query);			
	if (!$result) throw new Exception("Не смог сделать запись в таблицу {$table_market} (_запись_в_маркет_с_сайта)");	
}


// вывод на канал подробности уже готового лота (кнопка у админов ОПУБЛИКОВАТЬ)
function _вывод_на_каналы_с_сайта($команда) {
	global $table_market, $bot, $s3, $aws_bucket, $chat_id, $mysqli, $imgBB, $channel_podrobno, $channel_market;
	global $таблица_медиагруппа, $channel_media_market, $master, $message_id, $admin_group, $три_часа;
	global $smtp_server, $smtp_port, $smtp_login, $smtp_pass;	
	_очистка_таблицы_ожидание();
	$имя_клиента = substr(strrchr($команда, "."), 1);	
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
				$текст = "\n▪️{$валюта}\n▪️{$хештеги_города}\n▪️{$имя_клиента}";				
				$текст = str_replace('_', '\_', $текст);								
				$количество = substr_count($подробности, '[');				
				if ($количество == 0) {					
					$подробности = str_replace('_', '\_', $подробности);
				}							
				$текст .= "\n\n{$подробности}"; 								
				$текст = "{$хештеги}{$название_для_подробностей}{$текст}";	
				
				$uniqid = $строка['id_zakaz'];	
				
				// Если была замена фото, то $uniqid будет равен 'net'
				if ($uniqid != 'net') {
					$фото_с_амазон = $строка['url_tgraph'];
					
					$результат = $imgBB->upload($фото_с_амазон);
					if ($результат) {								
						$imgBB_url = $результат['url'];	
						_запись_в_маркет_с_сайта($имя_клиента, 'url_tgraph', $imgBB_url);
						
						$key = "temp{$uniqid}.jpg";
						$result = $s3->deleteObjects([
							'Bucket' => $aws_bucket,			
							'Delete' => [ 'Objects' => [ [ 'Key' => $key, ], ], ],
						]);
					}
				}else $imgBB_url = $строка['url_tgraph'];
				
				if ($imgBB_url) {
					$реплика = "Эта заявка с нашего сайта - www.prizmarket.ru\n[_________]({$imgBB_url})\n{$текст}";
				}elseif ($фото_с_амазон) {								
					$реплика = "Эта заявка с нашего сайта - www.prizmarket.ru\n[_________]({$фото_с_амазон})\n{$текст}";
				}else $реплика = $текст;	
				
				$ссылка_на_клиента = $строка['url_info_bot']; // https://wa.me/ххххххххххх				
				if (!$ссылка_на_клиента) $ссылка_на_клиента = "https://wa.me";				
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
					]
				]);				
				$inLine = ['inline_keyboard' => $кнопки];						
				$КаналИнфо = $bot->sendMessage($channel_podrobno, $реплика, markdown, $inLine);				
			}			
			if ($КаналИнфо) {
				$id_zakaz = $КаналИнфо['message_id'];				
				_запись_в_маркет_с_сайта($имя_клиента, 'id_zakaz', $id_zakaz);
				
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
				$сообщение_райминам = "{$имя_клиента}  лот {$id_zakaz}\nПубликация в {$время_публикации} мск";	
				$bot->sendMessage($chat_id, $сообщение_райминам);				
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
	global $bot, $master, $callback_query_id, $chat_id, $message_id, $mysqli, $table_market;
	
	if (strpos($имя_клиента, ".")!==false) {
		$id = strstr($имя_клиента, '.', true);		
		$имя_клиента = substr(strrchr($имя_клиента, "."), 1);
	}
	$query = "DELETE FROM ".$table_market." WHERE id_client=".$id." AND username='{$имя_клиента}'";
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

?>
