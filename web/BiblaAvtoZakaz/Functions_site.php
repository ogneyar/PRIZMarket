<?

/* Список всех функций:
**
** 
** _отправка_лота_админам  // отправка из сайта
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
function _запись_в_маркет_с_сайта() {
/*	global $table_market, $mysqli, $callback_from_id, $callback_from_username, $from_id, $from_username;	
	if (!$callback_from_id) $callback_from_id = $from_id;			
	if (!$callback_from_username) $callback_from_username = $from_username;	
	
	if (!$имя_столбца) {	
		$query = "DELETE FROM {$table_market} WHERE id_client={$callback_from_id} AND status=''";				
		if ($mysqli->query($query)) {			
			$query = "INSERT INTO {$table_market} (
			  `id_client`, `id_zakaz`, `kuplu_prodam`, `nazvanie`, `url_nazv`, `valuta`, 
			  `gorod`, `username`, `doverie`, `otdel`, `format_file`, `file_id`, `url_podrobno`, 
			  `status`, `podrobno`, `url_tgraph`, `foto_album`, `url_info_bot`, `date`
			) VALUES (
			  '{$callback_from_id}', '', '', '', '', '', '', '@{$callback_from_username}', '', '', '', '', '', '', '', '', '', '', ''
			)";							
		}else throw new Exception("Не смог удалить запись в таблице {$table_market} (_запись_в_таблицу_маркет)");
	}elseif ($номер_лота) {
		$query ="UPDATE {$table_market} SET {$имя_столбца}='{$действие}' WHERE id_zakaz={$номер_лота}";				
	}else {
		$query ="UPDATE {$table_market} SET {$имя_столбца}='{$действие}' WHERE id_client={$номер_клиента} AND status=''";				
	}
	$result = $mysqli->query($query);			
	if (!$result) throw new Exception("Не смог сделать запись в таблицу {$table_market} (_запись_в_таблицу_маркет)");			
*/
}


// вывод на канал подробности уже готового лота (кнопка у админов ОПУБЛИКОВАТЬ)
function _вывод_на_каналы_с_сайта($команда) {
	global $table_market, $bot, $s3, $aws_bucket, $chat_id, $mysqli, $imgBB, $channel_podrobno, $channel_market;
	global $таблица_медиагруппа, $channel_media_market, $master, $message_id, $admin_group, $три_часа;
	
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
				$фото_с_амазон = $строка['url_tgraph'];	
				if ($фото_с_амазон) {								
					$реплика = "Эта заявка сформирована на нашем сайте - prizmarket.ru\n[_________]({$фото_с_амазон})\n{$текст}";					
				}else $реплика = $текст;										
			
				$ссылка_на_клиента = $строка['url_info_bot']; // https://wa.me/79518233753					
				
				if (!$ссылка_на_клиента) $ссылка_на_клиента = "https://wa.me/79518233753";
				
				$кнопки = [
					[
						[ 'text' => 'КЛИЕНТ', 'url' => $ссылка_на_клиента ],
						[ 'text' => 'ГАРАНТ', 'url' => 'https://t.me/podrobno_s_PZP/1044' ]
					]
				];
				
			/*	if ($строка['foto_album'] == '1') {	
					$ссылка_на_канал_медиа = _публикация_на_канале_медиа($id_client);						
					if ($ссылка_на_канал_медиа) {					
						$кнопки = array_merge($кнопки, [ 
							[ [ 'text' => 'Фото', 'url' => $ссылка_на_канал_медиа ] ]
						]);
					}				
				}
			*/
			
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
				$uniqid = $строка['id_zakaz'];		
				$key = "temp{$uniqid}.jpg";
				
				$id_zakaz = $КаналИнфо['message_id'];
				$new_key = "{$id_zakaz}.jpg";
				
				$upload = $s3->copyObject([
					'Bucket'     => $aws_bucket,
					'Key'        => $new_key,
					'CopySource' => "{$aws_bucket}/{$key}"
				]);
				
				$result = $s3->deleteObjects([
					'Bucket' => $aws_bucket,			
					'Delete' => [ 'Objects' => [ [ 'Key' => $key, ], ], ],
				]);
				
				
/*			
				if ($ссылка_на_канал_медиа) {				
					_запись_в_таблицу_медиагрупа($id_client, $id_zakaz, $ссылка_на_канал_медиа);			
				}	
*/
				
				$ссыль_на_подробности = "https://t.me/{$КаналИнфо['chat']['username']}/{$id_zakaz}";		
				
				_запись_в_маркет_с_сайта($имя_клиента, 'id_zakaz', $id_zakaz);
				
				if (!$ссыль_в_названии) {					
					_запись_в_маркет_с_сайта($имя_клиента, 'url_nazv', $ссыль_на_подробности);				
					$ссыль_в_названии = $ссыль_на_подробности;						
				}					
				_запись_в_маркет_с_сайта($имя_клиента, 'url_podrobno', $ссыль_на_подробности);			
				
				_запись_в_маркет_с_сайта($имя_клиента, 'status', "одобрен");	
				
				$время = _ожидание_публикации($id_zakaz);
				$время_публикации = date("H:i", $время);
				
				
				// КОМУ
				$емаил = _дай_емаил($имя_клиента); 
				
				// ЧТО
				$сообщение = "&nbsp;&nbsp;{$имя_клиента} Вашему лоту присвоен номер {$id_zakaz}.<br>Публикация в {$время_публикации} мск.<br><br>&nbsp;&nbsp;На это письмо отвечать не нужно.";
				
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


?>
