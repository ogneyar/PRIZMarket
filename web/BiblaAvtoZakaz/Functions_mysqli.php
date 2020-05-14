<?
//include_once "Functions_site.php";
/*  Список функций для работы с таблицами MYSQL
**
** _запись_в_таблицу_маркет	-	// функция для записи данных в таблицу маркет
** _ожидание_ввода	-	-	-	// Функция, помечающая, что же клиент должен прислать
** _очистка_таблицы_ожидание	// Функция для очистки содержания таблицы ожидание
** _очистка_таблицы_медиа	-	// Функция для очистки содержания таблицы mediagroup
** _отправка_лота	-	-	-	// отправка лота (вида фото/видео с кэпшином) куда угодно
** _вывод_списка_лотов	-	-	// список лотов для повтора/удаления/просмотра
** _есть_ли_лоты	-	-	-	// проверка наличия по айди клиента
** _есть_ли_лот		-	-	-	// проверка наличия по номеру заказа
** _последняя_публикация	-	// проверка даты последней публикации
** _дай_айди	-	-	-	-	// функция возврата айди по юзернейму (если есть в базе)
** _узнать_имя_по_номеру_лота	// функция возвращающая юзернейм по номеру лота
** _есть_ли_у_клиента_альбом
** _есть_ли_такой_медиа_альбом
** _запись_в_таблицу_медиагрупа
** _установка_времени	-	-	// установка времени в таблицу маркет, когда была сделана заявка
** _ожидание_публикации
** _выбор_времени_публикации	// выбор времени публикации лота, проверка наличия очереди
** _удаление_лота_из_очереди
** _уведомление_о_публикации
** _нет_ли_брони
** _обнулить_секунды
*/

// Функция для записи данных в таблицу маркет
function _запись_в_таблицу_маркет($номер_клиента = null, $имя_столбца = null, $действие = null, $номер_лота = null) {
	global $table_market, $mysqli, $callback_from_id, $callback_from_username, $from_id, $from_username;	
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
}

// Функция, помечающая, что же клиент должен прислать
function _ожидание_ввода($имя_столбца = null, $последнее_действие = null) {	
	global $mysqli, $callback_from_id, $таблица_ожидание, $from_id;	
	if (!$callback_from_id) $callback_from_id = $from_id;	
	$response = false;	
	if ($имя_столбца) {//если указан столбец, то надо сделать запись в таблице ожидания ввода	
		$query = "SELECT id_client FROM {$таблица_ожидание} WHERE id_client={$callback_from_id}";		
		$result = $mysqli->query($query);		
		if ($result->num_rows>0) {			
			$query = "UPDATE {$таблица_ожидание} SET ojidanie='{$имя_столбца}' WHERE id_client={$callback_from_id}";		
			$result = $mysqli->query($query);			
			if (!$result) throw new Exception("Не смог обновить запись в таблице {$таблица_ожидание} (_ожидание_ввода)");			
			$response = true;			
		}else {			
			$query = "INSERT INTO {$таблица_ожидание} (
				`id_client`, `ojidanie`, `last`, `flag`
			) VALUES ('{$callback_from_id}', '{$имя_столбца}', '{$последнее_действие}', '0')";			
			$result = $mysqli->query($query);			
			if (!$result) throw new Exception("Не смог добавить запись в таблицу {$таблица_ожидание} (_ожидание_ввода)");			
			$response = true;			
		}				
	}else {//если не указан столбец, то надо проверить, есть ли ожидание ввода ..	
		$query = "SELECT * FROM {$таблица_ожидание} WHERE id_client={$callback_from_id}";		
		$result = $mysqli->query($query);		
		if ($result->num_rows>0) {		
			$resultArray = $result->fetch_all(MYSQLI_ASSOC);			
			$response = [
				'id_client' => $resultArray[0]['id_client'],
				'ojidanie' => $resultArray[0]['ojidanie'],
				'last' => $resultArray[0]['last'],
				'flag' => $resultArray[0]['flag']
			];		
		}				
	}	
	return $response; // boolean or array		
}

// Функция для очистки содержания таблицы ожидание
function _очистка_таблицы_ожидание() {
	global $mysqli, $callback_from_id, $таблица_ожидание, $from_id;	
	if (!$callback_from_id) $callback_from_id = $from_id;	
	$response = false;	
	$query = "DELETE FROM {$таблица_ожидание} WHERE id_client={$callback_from_id}";		
	$result = $mysqli->query($query);	
	if ($result) {	
		$response = true;	
	}else  throw new Exception("Не смог удалить запись в таблице {$таблица_ожидание} (_очистка_таблицы_ожидание)");	
	return $response;
}

// Функция для очистки содержания таблицы mediagroup
function _очистка_таблицы_медиа() {
	global $mysqli, $callback_from_id, $таблица_медиагруппа, $from_id;	
	if (!$callback_from_id) $callback_from_id = $from_id;		
	$query = "DELETE FROM {$таблица_медиагруппа} WHERE id_client={$callback_from_id} AND id='0'";		
	$result = $mysqli->query($query);	
	if ($result) {	
		return true;	
	}else  throw new Exception("Не смог удалить запись в таблице {$таблица_медиагруппа} (_очистка_таблицы_медиа)");	
}

// функция отправки лота 
function _отправка_лота($куда, $номер_лота, $админ = false, $предпросмотр = false, $inICQ = false) {	
	global $table_market, $callback_from_id, $from_id, $mysqli, $bot;	
	global $bot_icq, $aws_bucket, $aws_region, $ICQ_channel_market;
	if (!$callback_from_id) $callback_from_id = $from_id;
	if ($админ) {		
		$запрос = "SELECT * FROM {$table_market} WHERE id_zakaz='{$номер_лота}'";		
	}else {	
		$запрос = "SELECT * FROM {$table_market} WHERE id_client={$callback_from_id} AND id_zakaz='{$номер_лота}'";	
	}		
	$результат = $mysqli->query($запрос);	
	if ($результат) {		
		if ($результат->num_rows == 1) {		
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);			
			foreach ($результМассив as $строка) {		
				$id_client = $строка['id_client'];
				$файлАйди = $строка['file_id'];		
				$формат_файла = $строка['format_file'];				
				$название = $строка['nazvanie'];
				$ссыль_в_названии = $строка['url_nazv'];				
				$куплю_или_продам = $строка['kuplu_prodam'];						
				$валюта = $строка['valuta'];				
				$хештеги_города = $строка['gorod'];				
				
				$юзера_имя = $строка['username'];				
				
				$доверие = $строка['doverie'];
				$категория = $строка['otdel'];								
				$ссыль_на_подробности = $строка['url_podrobno'];
				if ($предпросмотр) {
					$inLine = [ 'inline_keyboard' => [
						[ [ 'text' => 'Отправить на публикацию', 'callback_data' => 'на_публикацию' ] ],
						[ [ 'text' => 'Изменить подробности', 'callback_data' => 'изменить_подробности' ] ],
						[ [ 'text' => 'В начало', 'callback_data' => 'старт' ] ]
					] ];
					$текст_после_названия = "\n▪️{$валюта}\n▪️{$хештеги_города}\n▪️{$юзера_имя}";
				}else {
					$inLine = [	'inline_keyboard' => 
						[ [ [ 'text' => 'Подробнее',
							  'url' => $ссыль_на_подробности ] ] ] ];
					$текст_после_названия = "\n▪️{$валюта}\n▪️{$хештеги_города}\n▪️{$юзера_имя}\n  лот {$номер_лота}";
				}				
				$хештеги = "{$куплю_или_продам}\n\n{$категория}\n▪️";					
				$хештеги = str_replace('_', '\_', $хештеги);					
				$текст_после_названия = str_replace('_', '\_', $текст_после_названия);
				if ($доверие) $текст_после_названия .= "\n✅ PRIZMarket доверяет❗️";
				$текст = "{$хештеги}[{$название}]({$ссыль_в_названии}){$текст_после_названия}";	
				
				if ($формат_файла == 'фото') {					
					$публикация = $bot->sendPhoto($куда, $файлАйди, $текст, markdown, $inLine);	
					
					if ($inICQ) {
						$фото_на_imgBB = $строка['url_tgraph'];
						//$фото_на_амазон = "https://{$aws_bucket}.s3.{$aws_region}.amazonaws.com/" . $номер_лота.".jpg";
						/*
						$кнопа =  [ [ [
									"text" => "Наш телеграм-канал",
									"url" => "https://teleg.link/prizm_market" ] ] ];
						*/
						$кнопа = [ [ [
									"text" => "Посетите наш сайт",
									"url" => "https://prizmarket.ru" ] ] ];
						if ($id_client == '7') {
                                                      $связь = _дай_связь($юзера_имя);
                                                }else{
						      if (strpos($юзера_имя, "@")!==false) {							
							      $связь = "https://teleg.link/".substr($юзера_имя, 1);	
						      }else $связь = "https://t.me/".$юзера_имя;
                                                } 
						$текст_после_названия_ICQ = "\n▪️{$валюта}\n▪️{$хештеги_города}\n▪️{$связь}\n  лот {$номер_лота}";
						//$текст_после_названия_ICQ = str_replace('_', '\_', $текст_после_названия_ICQ);
						if ($доверие) $текст_после_названия_ICQ .= "\n✅ PRIZMarket доверяет❗️";
						$хештеги_ICQ = "{$фото_на_imgBB}\n{$куплю_или_продам}\n\n{$категория}\n▪️";	
						$текст_ICQ = "{$хештеги_ICQ}{$название}{$текст_после_названия_ICQ}";	
						$bot_icq->sendText($ICQ_channel_market, $текст_ICQ, $кнопа);
					}
					
				}elseif ($формат_файла == 'видео') {						
					$публикация = $bot->sendVideo($куда, $файлАйди, $текст, markdown, $inLine);					
				}				
				if ($публикация) return $публикация;
			}		
		}else throw new Exception("Или нет заказа или больше одного.. (_отправка_лота)");	
	}else throw new Exception("Нет такого заказа.. (_отправка_лота)");	
}

// вывод на экран списка лотов для повтора/удаления/просмотра
function _вывод_списка_лотов($действие, $юзернейм = null, $все_лоты = false) {	
	global $bot, $table_market, $mysqli, $callback_from_id, $from_id, $chat_id;	
	if (!$callback_from_id) $callback_from_id = $from_id;				
	if ($все_лоты) {
		$запрос = "SELECT id_zakaz, kuplu_prodam, nazvanie FROM {$table_market} WHERE id_zakaz>0";
	}elseif ($юзернейм) {
		$айди_клиента = _дай_айди($юзернейм);
		if (!$айди_клиента) $айди_клиента = _дай_айди($юзернейм, 'info_users');
		if ($айди_клиента) {
			$запрос = "SELECT id_zakaz, kuplu_prodam, nazvanie FROM {$table_market} WHERE id_client={$айди_клиента} AND id_zakaz>0";	
		}else {
			$bot->sendMessage($chat_id, "Нет такого клиента в базе (_список_всех_лотов)");	
			exit('ok');
		}
	}else $запрос = "SELECT id_zakaz, kuplu_prodam, nazvanie FROM {$table_market} WHERE id_client={$callback_from_id} AND id_zakaz>0";	
	$результат = $mysqli->query($запрос);	
	if ($результат) {		
		$количество = $результат->num_rows;
		if ($количество > 0) {			
			if ($количество < 100) {
				$результМассив = $результат->fetch_all(MYSQLI_ASSOC);			
				$кнопки = [];						
				foreach ($результМассив as $строка) {				
					$название = $строка['nazvanie'];
					$кнопки = array_merge($кнопки, [[[
						'text' => "{$строка['kuplu_prodam']} {$название} (лот {$строка['id_zakaz']})",
						'callback_data' => "{$действие}:{$строка['id_zakaz']}"
					]]]);			
				}					
				$кнопки = array_merge($кнопки, [[[
						'text' => "*** в Главное меню ***",
						'callback_data' => "старт"
					]]]);			
				$inLine = [			
					'inline_keyboard' => $кнопки				
				];			
				if ($действие == 'повтор') $реплика = "Выберите лот для повтора.";			
				elseif ($действие == 'удаление') $реплика = "Выберите лот для удаления.";	
				elseif ($действие == 'покажи') $реплика = "Выберите лот для просмотра.";		
				$bot->sendMessage($chat_id, $реплика, null, $inLine);			
			}else $bot->sendMessage($chat_id, "Количество лотов - ".$количество);		
		}else $bot->sendMessage($chat_id, "Нет такой записи в БД (_вывод_списка_лотов)");		
	}else throw new Exception("Не получился запрос к БД (_вывод_списка_лотов)");
}

// Проверка наличия у клиента лотов в базе
function _есть_ли_лоты() {	
	global $mysqli, $from_id, $callback_from_id, $table_market, $callback_from_username, $from_username;
	global $bot, $master;	
	if (!$callback_from_id) $callback_from_id = $from_id;		
	if (!$callback_from_username) $callback_from_username = $from_username;		
    $response = false;	
	$query = "SELECT * FROM {$table_market} WHERE id_client={$callback_from_id} AND id_zakaz>0";	
	$result = $mysqli->query($query);	
	if ($result) {	
		if ($result->num_rows>0) {        
            $response = true;
		}	
	}else throw new Exception("Не смог узнать наличие лота у клиента {$callback_from_id} (_есть_ли_лоты)");	
    return $response;
}

// Проверка наличия лота в базе
function _есть_ли_лот($номер_лота) {	
	global $mysqli, $table_market;		
    $ответ = false;		
	if (strpos($номер_лота, ".")!==false) {
		return $ответ;
	}	
	$query = "SELECT * FROM {$table_market} WHERE id_zakaz={$номер_лота}";	
	$result = $mysqli->query($query);	
	if ($result) {	
		if ($result->num_rows>0) {        
            $ответ = true;
		}	
	}else throw new Exception("Не смог узнать наличие лота (_есть_ли_лот)");	
    return $ответ;
}

// Проверка давно ли была последняя публикация лота у данного клиента
function _последняя_публикация() {	
	global $mysqli, $from_id, $callback_from_id, $table_market;	
	if (!$callback_from_id) $callback_from_id = $from_id;		
    $response = false;	
	$query = "SELECT date FROM {$table_market} WHERE id_client={$callback_from_id}";	
	$result = $mysqli->query($query);	
	if ($result) {	
		if ($result->num_rows>0) {        
			$результат = $result->fetch_all(MYSQLI_ASSOC);			
			$время = time()-80000; // примерно 22 часа, а точнее 22,22222222222			
			$давно = true; // если публикация была давно			
			foreach ($результат as $строка) {				
				if ($строка['date']>$время) $давно = false;				
			}		
            if ($давно) $response = true;
		}else $response = true;	
	}else throw new Exception("Не смог узнать наличие лота у клиента {$callback_from_id} (_последняя_публикация)");	
    return $response;
}

// функция возвращает айди клиента по его юзернейму
function _дай_айди($Юнейм, $таблица = null) {	
	global $mysqli, $table_users, $master, $bot;		
    $ответ = false;		
	if (!$таблица) $таблица = $table_users;
	$Юнейм = str_replace(" ", "", $Юнейм);	
	$запрос = "SELECT id_client FROM {$таблица} WHERE user_name='{$Юнейм}'";	
	$результат = $mysqli->query($запрос);	
	if ($результат) {	
		if ($результат->num_rows>0) {			
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);        
            $ответ = $результМассив[0]['id_client'];			
		}//else $bot->sendMessage($master, "Не нашёл записей в базе (_дай_айди)");	
	}else $bot->sendMessage($master, "Не смог узнать айди клиента - {$Юнейм} (_дай_айди)");	
    return $ответ;
}

// функция, которая возвращает юзернейм клиента по номеру лота 
function _узнать_имя_по_номеру_лота($номер_лота) {	
	global $table_market, $callback_from_id, $mysqli, $bot, $master;	
	$запрос = "SELECT username FROM {$table_market} WHERE id_zakaz='{$номер_лота}'";		
	$результат = $mysqli->query($запрос);	
	if ($результат) {		
		if ($результат->num_rows > 0) {		
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);			
			return $результМассив[0]['username'];			
		}else throw new Exception("Или нет заказа или больше одного.. (_узнать_имя_по_номеру_лота)");	
	}else throw new Exception("Нет такого заказа.. (_узнать_имя_по_номеру_лота)");	
}


// Есть ли в таблице avtozakaz_pzmarket запись о том что у клиента имеется фотоальбом
function _есть_ли_у_клиента_альбом($id_zakaz = '0') {
	global $table_market, $mysqli, $callback_from_id, $from_id;	
	if (!$callback_from_id) {	
		$callback_from_id = $from_id;	
	}
	$query = "SELECT foto_album FROM {$table_market} WHERE id_client={$callback_from_id}".
		" AND id_zakaz={$id_zakaz} AND foto_album='1'";		
	$result = $mysqli->query($query);		
	if ($result->num_rows>0) {	
		return true;	
	}else return false;
}

// есть ли в таблице avtozakaz_mediagroup такой номер - медиа_айди
function _есть_ли_такой_медиа_альбом($медиа_айди) {
	global $таблица_медиагруппа, $mysqli, $callback_from_id, $from_id;	
	if (!$callback_from_id) {	
		$callback_from_id = $from_id;	
	}
	$query = "SELECT media_group_id FROM {$таблица_медиагруппа} WHERE id_client={$callback_from_id} AND media_group_id={$медиа_айди}";		
	$result = $mysqli->query($query);		
	if ($result->num_rows>0) {	
		return true;	
	}else return false;
}

// функция записи в таблицу avtozakaz_mediagroup
function _запись_в_таблицу_медиагрупа($id_client = null, $id_zakaz = null, $url_media_group = null) {	
	global $таблица_медиагруппа, $mysqli, $callback_from_id, $from_id, $media_group_id, $file_id, $формат_файла;
	if (!$callback_from_id) $callback_from_id = $from_id;			
	if ($id_client&&$id_zakaz&&$url_media_group) {		
		$query ="UPDATE {$таблица_медиагруппа} SET id='{$id_zakaz}', url='{$url_media_group}' WHERE id_client={$id_client} AND id='0'";		
		$result = $mysqli->query($query);			
		if (!$result) throw new Exception("Не смог обновить запись в таблице {$таблица_медиагруппа}");		
	}else {	
		$query = "INSERT INTO {$таблица_медиагруппа} (
			`id`, `id_client`, `media_group_id`, `format_file`, `file_id`, `url` 
		) VALUES (
			'0', '{$callback_from_id}', '{$media_group_id}', '{$формат_файла}', '{$file_id}', ''
		)";		
		$result = $mysqli->query($query);		
		if (!$result) throw new Exception("Не смог добавить запись в таблицу {$таблица_медиагруппа}");			
		return true;	
	}	
}

// функция становки времени публикации
function _установка_времени($номер_лота) {		
	global $table_market, $mysqli, $callback_from_id, $from_id;	
	if (!$callback_from_id) $callback_from_id = $from_id;				
	$время = time();	
	$query ="UPDATE {$table_market} SET date='{$время}' WHERE id_zakaz={$номер_лота}";		
	$result = $mysqli->query($query);			
	if (!$result) throw new Exception("Не смог обновить запись в таблице {$table_market}");	
	return true;
}

// функция постановки лота в ожидание публикации
function _ожидание_публикации($номер_лота = null) {		
	global $bot, $id_bota, $mysqli, $callback_from_id, $from_id, $channel_market, $admin_group, $master, $три_часа;		
	if (!$callback_from_id) $callback_from_id = $from_id;				
	$ответ = false;
	if ($номер_лота) {
		$запрос ="SELECT soderjimoe FROM `variables` WHERE id_bota={$id_bota} AND nazvanie='номер_лота' AND soderjimoe='{$номер_лота}'";				
		$результат = $mysqli->query($запрос);
		if ($результат) {
			if ($результат->num_rows > 0) {			
				$bot->sendMessage($callback_from_id, "Такой заказ в ожидании на публикацию уже есть!");	
				exit('ok');
			}else {
				$время_публикации = _выбор_времени_публикации();
				$запрос ="INSERT INTO `variables` (
					`id_bota`, `nazvanie`, `soderjimoe`, `opisanie`, `vremya`
				) VALUES (
					'{$id_bota}', 'номер_лота', '{$номер_лота}', '', '{$время_публикации}'
				)";						
				$результат = $mysqli->query($запрос);								
				if ($результат) {
					$ответ = $время_публикации;
				}else throw new Exception("Не смог добавить запись в таблицу `variables` (_ожидание_публикации)");				
			}			
		}else throw new Exception("Не смог узнать наличие записи в таблице `variables` (_ожидание_публикации)");			
	}else {	
		$UNIXtime = time();
		$UNIXtime_Moscow = $UNIXtime + $три_часа;	
		$запрос ="SELECT soderjimoe FROM `variables` WHERE id_bota={$id_bota} AND nazvanie='номер_лота' AND vremya<{$UNIXtime_Moscow}";				
		$результат = $mysqli->query($запрос);				
		if ($результат) {			
			if ($результат->num_rows > 0) {			
				$результМассив = $результат->fetch_all(MYSQLI_ASSOC);
				foreach($результМассив as $строка) {
					_удаление_лота_из_очереди($строка['soderjimoe']);
					
					// здесь true - это значит публикация от админа, false - отключен предпосмотр, он нужен 
					//перед новой подачей заявки на публикацию, а true в конце это публикация в icq new
					$результат = _отправка_лота($channel_market, $строка['soderjimoe'], true, false, true); 
					
					if ($результат) {						
						$ссылка = "https://t.me/{$результат['chat']['username']}/{$результат['message_id']}";
						// уведомляет только о заявках сделанных в телеграм 
						_уведомление_о_публикации($строка['soderjimoe'], $ссылка);
						$bot->sendMessage($admin_group, "Лот {$строка['soderjimoe']} опубликован.\n{$ссылка}", null, null, null, true);
					}else $bot->sendMessage($master, "Не смог отправить лот {$строка['soderjimoe']} (_ожидание_публикации)");
				}				
			}
		}else throw new Exception("Не смог осуществить запрос к таблице `variables` (_ожидание_публикации)");	
	}	
	return $ответ;	
}

// функция проверки наличия лотов в ожидании, если есть, то показывает время последнего в очереди
function _выбор_времени_публикации() {
	global $mysqli, $id_bota, $три_часа, $master, $bot;
	$ответ = false;
	$UNIXtime = time();
	$UNIXtime_Moscow = $UNIXtime + $три_часа;	
	$время = _обнулить_секунды($UNIXtime_Moscow);
	$запрос ="SELECT vremya FROM `variables` WHERE id_bota={$id_bota} AND nazvanie='номер_лота'";			
	$результат = $mysqli->query($запрос);
	if ($результат) {	
		$количество = $результат->num_rows;
		if ($количество > 0) {
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);			
			$последняя_в_очереди = 0;
			foreach($результМассив as $строка) {
				if ($строка['vremya'] > $последняя_в_очереди) $последняя_в_очереди = $строка['vremya'];
			}			
			if ($последняя_в_очереди > $время) $ответ = $последняя_в_очереди + 1200; // + 20 мин
		}		
		if (!$ответ) {			
			$минута = date("i", $время);
			if ($минута > 48) {
				$смещение = 70 - $минута;
			}elseif ($минута > 28) {
				$смещение = 50 - $минута;
			}elseif ($минута > 8) {
				$смещение = 30 - $минута;
			}else $смещение = 10 - $минута;
			$ответ = $время + $смещение * 60;		
		}		
		$счётчик = false;
		while ($счётчик == false) {
			$бронь = _нет_ли_брони($ответ);
			if ($бронь == "свободно") {
				$счётчик = true;
			}else {
				$ответ = $ответ + 1200;
			}				
		}		
	}else throw new Exception("Не смог сделать запрос к таблице `variables` (_выбор_времени_публикации)");
	return $ответ;
}

// функция удаления лота из очереди ожидания публикации
function _удаление_лота_из_очереди($номер_лота) {
	global $id_bota, $mysqli;
	$запрос ="DELETE FROM `variables` WHERE id_bota={$id_bota} AND nazvanie='номер_лота' AND soderjimoe='{$номер_лота}'";
	if ($mysqli->query($запрос)) return true;
}

// уведомление клиента о совершённой публикации и отсылка ему ссылки на опубликованный лот
function _уведомление_о_публикации($номер_лота, $ссылка) {
	global $bot, $id_bota, $mysqli, $table_market, $master;	
	$запрос ="SELECT id_client, username FROM {$table_market} WHERE id_zakaz={$номер_лота}";
	$результат = $mysqli->query($запрос);
	if ($результат) {
		if ($результат->num_rows > 0) {
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);
			if ($результМассив[0]['id_client'] == '7') {
				return "7";
			}else {
				$bot->sendMessage($результМассив[0]['id_client'], $результМассив[0]['username']." Ваш лот опубликован.\n\n{$ссылка}\n\n/start", null, null, null, true);	
			}
		}else $bot->sendMessage($master, "Не смог найти лот {$номер_лота} (_уведомление_о_публикации)");
	}else $bot->sendMessage($master, "Не смог узнать есть ли лот {$номер_лота} (_уведомление_о_публикации)");
}

// функция проверяет есть ли бронь публикации на заданное время 
function _нет_ли_брони($время) {		// если нет брОни, вернёт "свободно"
	global $bot, $id_bota, $mysqli;					
	$ответ = false;
	$запрос ="SELECT * FROM `variables` WHERE id_bota={$id_bota} AND nazvanie='бронь' AND vremya='{$время}'";
	$результат = $mysqli->query($запрос);
	if ($результат) {			
		if ($результат->num_rows == 0) $ответ = "свободно";
	}else throw new Exception("Не смог узнать наличие записи в таблице `variables` (_нет_ли_брони)");		
	return $ответ;	
}

// функция удаляет секунды реального времени в юникс времени
function _обнулить_секунды($юникс_время) {	
	$ответ = false;
	$год = date("Y", $юникс_время);
	$месяц = date("m", $юникс_время);
	$день = date("d", $юникс_время);			
	$час = date("H", $юникс_время);
	$минута = date("i", $юникс_время);			
	$ответ = mktime($час, $минута, 0, $месяц, $день, $год);
	return $ответ;
}
















?>
