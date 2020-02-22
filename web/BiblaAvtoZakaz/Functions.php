<?
/* Список всех функций:
**
** _start_AvtoZakazBota
** _инфо_автоЗаказБота
** _есть_ли_лоты   // по айди клиента
** _есть_ли_лот    // по номеру заказа
** _последняя_публикация
** exception_handler
** _existence
** _дай_айди
**
** _создать
** _вывод_списка_лотов
** _повтор
** _отправка_лота
** _отправить_на_повтор
** _установка_времени
** _удаление
** _удалить_выбранный_лот
** _узнать_имя_по_номеру_лота
** _куплю
** _продам
** _продам_куплю
** _запись_в_таблицу_маркет
** _ожидание_ввода
** _очистка_таблицы_ожидание
** _очистка_таблицы_медиа
** _ссылка_в_названии
** _да_нужна
** _не_нужна
** _выбор_категории
** _выбор_валюты
** _рубль
** _доллар
** _евро
** _юань
** _гривна
** _фунт
** _призм
** _когда_валюта_выбрана
** _ввод_местонахождения
** _отправьте_файл
** _нужен_ли_фотоальбом
** _нужен_альбом
** _есть_ли_у_клиента_альбом
** _есть_ли_такой_медиа_альбом
** _запись_в_таблицу_медиагрупа
** _не_нужен_альбом
** _опишите_подробно
** _предпросмотр_лота
**
** _на_публикацию
** _изменить_подробности
** _ожидание_результата
**
** _отправка_лота_админам
**
** _редактировать_название
** _редактировать_ссылку
** _редактировать_хештеги
** _редактировать_подробности
** _редактировать_фото
**
** _вывод_лота_на_каналы
** _публикация_на_канале_медиа
** _отправка_сообщений_инфоботу
**
** _доверяет
** _не_доверяет
** _отказать
** _удалить_лот
** 
** _возврат_лотов_для_инлайн
**
**
** _редактор_лотов
** _редакт_таблицы_маркет
**
** _показать_редакт
** _доверяет_редакт
** _не_доверяет_редакт
** _название_редакт 
** _ссылку_редакт
** _хештеги_редакт
** _подробности_редакт
** _фото_редакт
**
** _редакт_лота_на_канале_подробности
**
** _список_всех_лотов
**
*/

// функция старта бота ИНФОРМАЦИЯ О ПОЛЬЗОВАТЕЛЯХ
function _start_AvtoZakazBota() {		

	global $bot, $table_users, $chat_id, $callback_from_first_name, $from_first_name, $HideKeyboard;
	
	_очистка_таблицы_ожидание();
	
	if (!$callback_from_first_name) $callback_from_first_name = $from_first_name;
	
	$админ = $bot->this_admin($table_users);
	
	if ($админ) {
		
		$ReplyKey = [
			'keyboard' => [
				[			
					[
						'text' => "Редактор лотов"
					]
				]
			],
			'resize_keyboard' => true,
			'selective' => true,
		];
	
		$bot->sendMessage($chat_id, "Здравствуй МАСТЕР *".$callback_from_first_name."*!", markdown, $ReplyKey);
	
	}else {
	
		$bot->sendMessage($chat_id, "Добро пожаловать, *".$callback_from_first_name."*!", markdown, $HideKeyboard);
		
	}

    _инфо_автоЗаказБота();	
	
	exit('ok');
	
}

// Краткая информация, перед началом работы с ботом
function _инфо_автоЗаказБота() {

	global $bot, $chat_id, $тех_поддержка;
	
	$клавиатура = [
		[
			[		
				'text' => 'Правила',
				'url' => 'https://t.me/podrobno_s_PZP/562'		
			]
		],
		[
			[		
				'text' => 'Создать заявку',
				'callback_data' => 'создать'		
			]
		]
	];
	
	if (_есть_ли_лоты()) {
	
		$клавиатура = array_merge($клавиатура, [
			[
				[
					'text' => 'Повтор публикации',
					'callback_data' => 'повторить'
				],
				[
					'text' => 'Удалить публикацию',
					'callback_data' => 'удалить'
				]
			]
		]);
		
	}
		
	$inLine = [ 'inline_keyboard' => $клавиатура ];
	
	$reply = "Это Бот для подачи заявки на публикацию вашего лота на канале [Покупки на PRIZMarket]".
		"(https://t.me/prizm_market)\n\nДля подачи заявки на публикацию пошагово пройдите".
		" по всем пунктам. Для начала изучите 'Правила', а затем нажмите кнопку ".
		"'Создать заявку'. После создания заявки появится возможность повтора публикации.{$тех_поддержка}";

	$bot->sendMessage($chat_id, $reply, markdown, $inLine, null, true);

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
	
	}else throw new Exception("Не смог узнать наличие лота у клиента {$callback_from_id}");
	
    return $response;

}



// Проверка наличия лота в базе
function _есть_ли_лот($номер_лота) {	
	global $mysqli, $table_market;		
    $ответ = false;	
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
	
    $resonse = false;	

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
	
	}else throw new Exception("Не смог узнать наличие лота у клиента {$callback_from_id}");
	
    return $response;

}




// при возникновении исключения вызывается эта функция
function exception_handler($exception) {

	global $bot, $master;
	
	$bot->sendMessage($master, "Ошибка! ".$exception->getCode()." ".$exception->getMessage());	
  
	exit('ok');  
	
}

// Проверка наличия клиента в базе
function _existence($table) {
	
	global $mysqli, $from_id, $from_first_name, $from_last_name, $from_username;

    $resonse = false;
	
	$from_Uname = '';
	
    if ($from_username != '') $from_Uname = "@".$from_username;

	$query = "SELECT * FROM {$table} WHERE id_client={$from_id}";
	
	$result = $mysqli->query($query);
	
	if ($result) {
	
		if ($result->num_rows>0) {
                   
            $arrayResult = $result->fetch_all(MYSQLI_ASSOC);

			foreach ($arrayResult as $row) {

				if ($row['first_name']==$from_first_name&&$row['last_name']==$from_last_name&&$row['user_name']==$from_Uname) $response = true;

			}

		}		
	
	}else throw new Exception("Не смог узнать наличие клиента в таблице {$table}");
	
    return $response;

}


// функция возвращает айди клиента по его юзернейму
function _дай_айди($Юнейм) {	
	global $mysqli, $table_users, $master, $bot;		
    $ответ = false;		
	$Юнейм = str_replace(" ", "", $Юнейм);	
	$запрос = "SELECT id_client FROM {$table_users} WHERE user_name='{$Юнейм}'";	
	$результат = $mysqli->query($запрос);	
	if ($результат) {	
		if ($результат->num_rows>0) {			
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);        
            $ответ = $результМассив[0]['id_client'];			
		}else $bot->sendMessage($master, "Не нашёл записей в базе (_дай_айди)");	
	}else $bot->sendMessage($master, "Не смог узнать айди клиента - {$Юнейм}");	
    return $ответ;
}



//------------------------------------------
// Начало создания заявки на публикацию лота 
//------------------------------------------
function _создать() {

	global $bot, $from_id, $message_id, $callback_query_id, $callback_from_id;	
	
	$давно = _последняя_публикация();
	
	if ($давно) {
	
		if (!$callback_from_id) {
		
			$callback_from_id = $from_id;
			
		}else $bot->answerCallbackQuery($callback_query_id, "Начнём!");
	
	}else {
		
		if ($callback_query_id) {
			
			$bot->answerCallbackQuery($callback_query_id, "Безоплатно можно публиковать только раз в сутки один лот!", true);
			
		}
		
		exit('ok');
		
	}
	
	_запись_в_таблицу_маркет();
	
	_очистка_таблицы_медиа();
	
	$inLine = [
		'inline_keyboard' => [
			[
				[
					'text' => '#продам',
					'callback_data' => 'продам'
				],
				[
					'text' => '#куплю',
					'callback_data' => 'куплю'
				]
			]
		]
	];
	
	$reply = "|\n|\n|\n|\n|\n|\n|\n|\nВыберите необходимое действие:";
	
	$bot->sendMessage($callback_from_id, $reply, null, $inLine);

}



//-----------------------------------------------------------------------
function _вывод_списка_лотов($действие) {	
	global $bot, $table_market, $mysqli, $callback_from_id, $from_id;	
	if (!$callback_from_id) $callback_from_id = $from_id;			
	$запрос = "SELECT id_zakaz, kuplu_prodam, nazvanie FROM {$table_market} WHERE id_client={$callback_from_id} AND id_zakaz>0";	
	$результат = $mysqli->query($запрос);	
	if ($результат) {		
		if ($результат->num_rows>0) {			
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
			$bot->sendMessage($callback_from_id, $реплика, null, $inLine);				
		}else throw new Exception("Нет такой записи в БД");		
	}else throw new Exception("Не получился запрос к БД");
}
//--------------------------------------------------------------



// функция вывода на экран лота, который необходимо повторить
function _повтор($номер_лота) {
	
	global $callback_from_id, $bot, $callback_query_id;
	
	$давно = _последняя_публикация();
	
	if ($давно) {
	
		_отправка_лота($callback_from_id, $номер_лота);	
	
		$inLine = [
			'inline_keyboard' => [
				[
					[
						'text' => 'Да',
						'callback_data' => "отправить_на_повтор:".$номер_лота
					],
					[
						'text' => 'Нет',
						'callback_data' => "старт"
					]
				]
			]
		];				
		
		$bot->sendMessage($callback_from_id, "|\n|\n|\nПовторить? Если хотите повторить публикацию этого лота, нажмите 'Да'.", null, $inLine);
	
	}else {
		
		if ($callback_query_id) {
			
			$bot->answerCallbackQuery($callback_query_id, "Безоплатно можно публиковать только раз в сутки один лот!", true);
			
		}
		
		exit('ok');
		
	}	

}



// функция отправки лота 
function _отправка_лота($куда, $номер_лота, $админ = false) {	
	global $table_market, $callback_from_id, $mysqli, $bot;	
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
				//$подробности = $строка['podrobno'];	
				$ссыль_на_подробности = $строка['url_podrobno'];								
				$inLine = [	'inline_keyboard' => 
					[ [ [ 'text' => 'Подробнее',
						  'url' => $ссыль_на_подробности ] ] ] ];								
				$хештеги = "{$куплю_или_продам}\n\n{$категория}\n▪️";				
				$хештеги = str_replace('_', '\_', $хештеги);				
				$текст_после_названия = "\n▪️{$валюта}\n▪️{$хештеги_города}\n▪️{$юзера_имя}\n  лот {$номер_лота}";
				$текст_после_названия = str_replace('_', '\_', $текст_после_названия);					
				if ($доверие) $текст_после_названия .= "\n✅ PRIZMarket доверяет❗️"; 					
				$текст = "{$хештеги}[{$название}]({$ссыль_в_названии}){$текст_после_названия}";					
				if ($формат_файла == 'фото') {					
					$публикация = $bot->sendPhoto($куда, $файлАйди, $текст, markdown, $inLine);					
				}elseif ($формат_файла == 'видео') {						
					$публикация = $bot->sendVideo($куда, $файлАйди, $текст, markdown, $inLine);					
				}						
			}		
		}else throw new Exception("Или нет заказа или больше одного..");	
	}else throw new Exception("Нет такого заказа..");	
}



// функция вывода АДМИНАМ на экран лота, с просьбой о необходимости повторить
function _отправить_на_повтор($номер_лота) {
	
	global $admin_group, $bot, $callback_from_id, $callback_query_id;
	
	$давно = _последняя_публикация();
	
	if ($давно) {
	
		_отправка_лота($admin_group, $номер_лота);	
		
		_установка_времени($номер_лота);
		
		$юзер_неим = _узнать_имя_по_номеру_лота($номер_лота);		
		
		$bot->sendMessage($admin_group, "{$юзер_неим} просит: Повторите публикацию, будьте так любезны, заранее благодарю.");
		
		$bot->sendMessage($callback_from_id, "|\n|\n|\nОтправил, ожидайте ответ.");	
		
		$bot->answerCallbackQuery($callback_query_id, "Ожидайте!");
	
	}else {
		
		$bot->answerCallbackQuery($callback_query_id, "Безоплатно можно публиковать только раз в сутки один лот!", true);
		
		exit('ok');
		
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



// функция вывода на экран лота, который необходимо удалить
function _удаление($номер_лота) {
	
	global $callback_from_id, $bot;
	
	_отправка_лота($callback_from_id, $номер_лота);	
	
	$inLine = [
		'inline_keyboard' => [
			[
				[
					'text' => 'Да',
					'callback_data' => "удалить_выбранный_лот:".$номер_лота
				],
				[
					'text' => 'Нет',
					'callback_data' => "старт"
				]
			]
		]
	];				
	
	$bot->sendMessage($callback_from_id, "|\n|\n|\nУдалить? Если хотите удалить этот лот из базы нажмите 'Да'.", null, $inLine);

}



// функция удаления лота из базы данных
function _удалить_выбранный_лот($номер_лота) {
	
	global $table_market, $таблица_медиагруппа, $callback_query_id, $mysqli, $bot, $master;
	
	$запрос = "DELETE FROM {$table_market} WHERE id_zakaz='{$номер_лота}'";
	
	$результат = $mysqli->query($запрос);
	
	if ($результат) {
		
		_инфо_автоЗаказБота();
		
		$bot->answerCallbackQuery($callback_query_id, "Лот удалён из базы!");
		
		$запрос = "DELETE FROM {$таблица_медиагруппа} WHERE id='{$номер_лота}'";
	
		$результат = $mysqli->query($запрос);
	
	}else throw new Exception("Не смог удалить лот..");	

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
			
		}else throw new Exception("Или нет заказа или больше одного..");
	
	}else throw new Exception("Нет такого заказа..");	

}



// Если клиент выбрал хештег КУПЛЮ
function _куплю() { _продам_куплю('#куплю'); }

// Если клиент выбрал хештег ПРОДАМ
function _продам() { _продам_куплю('#продам'); }



// Обработка выбранного действия ПРОДАМ/КУПЛЮ, с занесением в базу и ожиданием ввода НАЗВАНИЯ
function _продам_куплю($действие) {

	global $bot, $message_id, $callback_query_id, $callback_from_id;
	
	_запись_в_таблицу_маркет($callback_from_id, 'kuplu_prodam', $действие);
	
	_ожидание_ввода('nazvanie', 'kuplu_prodam');
	
	$bot->answerCallbackQuery($callback_query_id, "Ожидаю ввод названия!");	

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
	
	$reply = "Введите название:";
	
	$bot->sendMessage($callback_from_id, $reply, null, $ReplyKey);	

}


// Функция для записи данных в таблицу маркет
function _запись_в_таблицу_маркет($номер_клиента = null, $имя_столбца = null, $действие = null) {

	global $table_market, $mysqli, $callback_from_id, $callback_from_username, $from_id, $from_username;
	
	if (!$callback_from_id) $callback_from_id = $from_id;		
	
	if (!$callback_from_username) $callback_from_username = $from_username;
	
	if (!$имя_столбца) {
	
		$query = "DELETE FROM {$table_market} WHERE id_client={$callback_from_id} AND status=''";
		
		$result = $mysqli->query($query);
		
		if ($result) {
			
			$query = "INSERT INTO {$table_market} (
			  `id_client`, `id_zakaz`, `kuplu_prodam`, `nazvanie`, `url_nazv`,
			  `valuta`, `gorod`, `username`, `doverie`, `otdel`, `format_file`,
			  `file_id`, `url_podrobno`, `status`, `podrobno`, `url_tgraph`,
			  `foto_album`, `url_info_bot`, `date`
			) VALUES (
			  '{$callback_from_id}', '', '', '', '', '', '', '@{$callback_from_username}', '', '', '', '', '', '', '', '', '', '', ''
			)";
						
			$result = $mysqli->query($query);
			
			if (!$result) throw new Exception("Не смог добавить запись в таблицу {$table_market}");
			
		}else throw new Exception("Не смог удалить запись в таблице {$table_market}");
		
	}else {
		
		$query ="UPDATE {$table_market} SET {$имя_столбца}='{$действие}' WHERE id_client={$номер_клиента} AND status=''";
		
		$result = $mysqli->query($query);
			
		if (!$result) throw new Exception("Не смог обновить запись в таблице {$table_market}");
		
		
	}

}



// Функция для очистки содержания таблицы mediagroup
function _очистка_таблицы_медиа() {

	global $mysqli, $callback_from_id, $таблица_медиагруппа, $from_id;
	
	if (!$callback_from_id) $callback_from_id = $from_id;	
	
	$query = "DELETE FROM {$таблица_медиагруппа} WHERE id_client={$callback_from_id} AND id='0'";
		
	$result = $mysqli->query($query);
	
	if ($result) {
	
		return true;
	
	}else  throw new Exception("Не смог удалить запись в таблице {$таблица_медиагруппа}");	

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
			
			if (!$result) throw new Exception("Не смог обновить запись в таблице {$таблица_ожидание}");
			
			$response = true;
			
		}else {
			
			$query = "INSERT INTO {$таблица_ожидание} (
				  `id_client`,
				  `ojidanie`,
				  `last`,
				  `flag`
			) VALUES ('{$callback_from_id}', '{$имя_столбца}', '{$последнее_действие}', '0')";	
		
			$result = $mysqli->query($query);
			
			if (!$result) throw new Exception("Не смог добавить запись в таблицу {$таблица_ожидание}");
			
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
	
	}else  throw new Exception("Не смог удалить запись в таблице {$таблица_ожидание}");
	
	return $response;

}


// После ввода клиентом НАЗВАНИЯ предлагается на выбор, нужнали ссылка вшитая в название
function _ссылка_в_названии() {

	global $bot, $chat_id;
	
	$inLine = [
		'inline_keyboard' => [
			[
				[
					'text' => 'Да',
					'callback_data' => 'да_нужна'
				],
				[
					'text' => 'Нет',
					'callback_data' => 'не_нужна'
				]
			]
		]
	];
	
	$reply = "|\n|\n|\n|\n|\n|\n|\n|\nНужна ли Вам Ваша ссылка, вшитая в названии?\n\nЕсли не знаете или не поймёте о чём речь, нажмите 'НЕТ'.";
	
	$bot->sendMessage($chat_id, $reply, null, $inLine);

}


// Нужна ли Вам Ваша ссылка, вшитая в названии?
function _да_нужна() {

	global $bot, $chat_id, $callback_query_id;
	
	_ожидание_ввода('url_nazv', 'nazvanie');
	
	$bot->answerCallbackQuery($callback_query_id, "Ожидаю ввода Вашей ссылки!");	

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
	
	$reply = "Пришлите мне ссылку, типа:\n\n  https://mysite.ru/supersite/";
	
	$bot->sendMessage($chat_id, $reply, null, $ReplyKey);

}


// Нужна ли Вам Ваша ссылка, вшитая в названии?
function _не_нужна() {
	
	_выбор_категории();
	
}




// выбор категории в которой будет находиться лот?
function _выбор_категории() {

	global $bot, $chat_id, $категории;		
	
	$список_категорий = [];			
			
	for ($i=0; $i<12; $i++) {
				
		$список_категорий = array_merge($список_категорий, [
			[
				[
					'text' => $категории[$i],
					'callback_data' => $категории[$i]
				],
				[
					'text' => $категории[$i+1],
					'callback_data' => $категории[$i+1]
				]
			]
		]);
		
		$i++;
		
	}
	
	$inLine = [
	
		'inline_keyboard' => $список_категорий
		
	];
	
	$reply = "Выберите категорию, к которой больше всего подходит Ваш товар/услуга.";
	
	$bot->sendMessage($chat_id, $reply, null, $inLine);


}



// Предлагаются на выбор разные валюты
function _выбор_валюты() {
	
	global $bot, $chat_id;
	
	$inLine = [
		'inline_keyboard' => [
			[
				[
					'text' => '₽',
					'callback_data' => 'рубль'
				],
				[
					'text' => '$',
					'callback_data' => 'доллар'
				],
				[
					'text' => '€',
					'callback_data' => 'евро'
				]
			],
			[
				[
					'text' => '¥',
					'callback_data' => 'юань'
				],
				[
					'text' => '₴',
					'callback_data' => 'гривна'
				],
				[
					'text' => '£',
					'callback_data' => 'фунт'
				]
			],
			[
				[
					'text' => 'Только PRIZM!',
					'callback_data' => 'призм'
				]
			]
		]
	];
	
	$reply = "|\n|\n|\n|\n|\n|\n|\n|\nВыберите валюту, с которой Вы работаете, помимо PRIZM.";
	
	$bot->sendMessage($chat_id, $reply, null, $inLine);

}


// Если выбрана валюта
function _рубль() {	_когда_валюта_выбрана('₽'); }

// Если выбрана валюта
function _доллар() { _когда_валюта_выбрана('$'); }

// Если выбрана валюта
function _евро() { _когда_валюта_выбрана('€'); }

// Если выбрана валюта
function _юань() { _когда_валюта_выбрана('¥'); }

// Если выбрана валюта
function _гривна() { _когда_валюта_выбрана('₴'); }

// Если выбрана валюта
function _фунт() { _когда_валюта_выбрана('£'); }

// Если выбрана валюта
function _призм() { _когда_валюта_выбрана(); }


// Когда уже выбрана валюта
function _когда_валюта_выбрана($валюта = null) {	

	global $callback_from_id;
	
	if ($валюта) {
		
		$валюта.= " / PZM";
		
	}else {
		
		$валюта = "PZM";
		
	}
	
	_запись_в_таблицу_маркет($callback_from_id, 'valuta', $валюта);
	
	_ввод_местонахождения();	

}


//
function _ввод_местонахождения() {

	global $bot, $callback_query_id, $callback_from_id, $from_id;

	if (!$callback_from_id) {
	
		$callback_from_id = $from_id;
	
	}else $bot->answerCallbackQuery($callback_query_id, "Ожидаю ввода местонахождения!");	 
	
	_ожидание_ввода('gorod', 'valuta');

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
	
	$reply = "Введите хештеги местонахождения: (не больше трёх)".
		"\n\nВНИМАНИЕ: вводите хештеги БЕЗ пробелов!\n".
		"(#Весь мир 👈🏻 это будет ошибка)\n".		
		"Можно использовать _ (подчёркивание) вместо пробела. Никакие другие ".
		"символы вводить нельзя. В случае неверного ввода команда PRIZMarket ".
		"может отклонить заявку.\n".
		"ОБЯЗАТЕЛЬНО ставьте пробел между двумя разными хештегами!\n".
		"(#Весь_мир#Россия 👈🏻 это будет ошибка)".
		"\n\nПример верного ввода:\n#Весь_мир #Россия #Ростов_на_Дону";
	
	$bot->sendMessage($callback_from_id, $reply, null, $ReplyKey);		

}


//
function _отправьте_файл() {

	global $bot, $chat_id;
	
	_ожидание_ввода('format_file', 'gorod');
	
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
	
	$reply = "Отправьте один файл. \n\nФото или видео. \n\nЕсли пришлёте больше, я приму только один файл,".
		" остальные проигнорирую.\nЕсли Вы хотите скинуть много фото, Вы это сможете сделать чуть позже!\n\n".
		"(учтите: видео должно быть коротким, не более 5 МБ)";
	
	$bot->sendMessage($chat_id, $reply, null, $ReplyKey);		

}


// Спрашивается, нужен ли клиенту фотоальбом, на отдельном канале?
function _нужен_ли_фотоальбом() {

	global $bot, $chat_id;
	
	$inLine = [
		'inline_keyboard' => [
			[
				[
					'text' => 'Да',
					'callback_data' => 'нужен_альбом'
				],
				[
					'text' => 'Нет',
					'callback_data' => 'не_нужен_альбом'
				]
			]
		]
	];
	
	$reply = "|\n|\n|\n|\n|\n|\n|\n|\nНужен ли Вам фотоальбом, размещённый на отдельном канале?\n\nЕсли не знаете или не поймёте о чём речь, нажмите 'НЕТ'.";
	
	$bot->sendMessage($chat_id, $reply, null, $inLine);

}


function _нужен_альбом() {
	
	global $bot, $chat_id, $callback_from_id;
	
	_очистка_таблицы_медиа();
	
	_запись_в_таблицу_маркет($callback_from_id, 'foto_album', '1');
	
	_ожидание_ввода('foto_album', 'foto_album');
	
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
	
	$reply = "|\n|\n|\n|\n|\n|\n|\n|\nСкиньте мне разом все фото, которые должны оказаться в альбоме (НЕ по одной фотке)";
	
	$bot->sendMessage($chat_id, $reply, null, $ReplyKey);
	
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
			`id`,
			`id_client`,
			`media_group_id`,
			`format_file`,
			`file_id`,
			`url`
		) VALUES (
			'0', '{$callback_from_id}', '{$media_group_id}', '{$формат_файла}', '{$file_id}', ''
		)";
		
		$result = $mysqli->query($query);
		
		if (!$result) throw new Exception("Не смог добавить запись в таблицу {$таблица_медиагруппа}");
				
		return true;
	
	}
	
}




function _не_нужен_альбом() {

	global $callback_from_id, $from_id;
	
	if (!$callback_from_id) $callback_from_id = $from_id;
	
	_очистка_таблицы_медиа();
	
	_запись_в_таблицу_маркет($callback_from_id, 'foto_album', '0');
	
	_опишите_подробно();
	
}


// функция предлагающая ввести ПОДРОБНую информацию о товаре/услуге
function _опишите_подробно($хорошо = null) {

	global $bot, $chat_id;
	
	if ($хорошо) {
		
		_ожидание_ввода('podrobno', $хорошо);
		
	}else _ожидание_ввода('podrobno', 'foto_album');
	
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
	
	$reply = "Теперь опишите подробно Ваш товар/услугу для канала Подробности, на который будет ссылаться".
		" Ваш лот.\nСсылки на сайт или соцсети приветствуются.\n(ссылки не должны быть реферальными)\n\nДостаточно подробно. \n\nНо, не переусердствуйте, ведь Вы же не намерены переутомить своих".
		" потенциальных клиентов?\n\nКоличество вводимых символов должно быть не менее 100 и не более 2000.";
	
	$bot->sendMessage($chat_id, $reply, null, $ReplyKey);
	
}





// перед отправкой лота админам показывается клиенту вся введённая информация 
function _предпросмотр_лота() {

	global $from_id, $table_market, $bot, $mysqli, $master;

	$запрос = "SELECT * FROM {$table_market} WHERE id_client={$from_id} AND id_zakaz='0'";
		
	$результат = $mysqli->query($запрос);
	
	if ($результат) {
		
		if ($результат->num_rows == 1) {
		
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);
			
			foreach ($результМассив as $строка) {
			
				$файлАйди = $строка['file_id'];		
				$формат_файла = $строка['format_file'];				
				$название = $строка['nazvanie']; 
				$ссыль_в_названии = $строка['url_nazv'];	
				if ($ссыль_в_названии) {					
					$название_для_подробностей = "[{$название}]({$ссыль_в_названии})";	
				}else $название_для_подробностей = str_replace('_', '\_', $название);
				$куплю_или_продам = $строка['kuplu_prodam'];
				$валюта = $строка['valuta'];				
				$хештеги_города = $строка['gorod'];				
				$юзера_имя = $строка['username'];				
				$доверие = $строка['doverie'];
				$категория = $строка['otdel'];				
				$подробности = $строка['podrobno'];			
				
				$хештеги = "{$куплю_или_продам}\n\n{$категория}\n▪️";				
				$хештеги = str_replace('_', '\_', $хештеги);
				
				$текст = "\n▪️{$валюта}\n▪️{$хештеги_города}\n▪️{$юзера_имя}";				
				$текст = str_replace('_', '\_', $текст);				
				$текст = "{$хештеги}{$название_для_подробностей}{$текст}";
				
				$bot->sendMessage($from_id, $подробности);
				
				$inLine = [
					'inline_keyboard' => [
						[
							[
								'text' => 'Отправить на публикацию',
								'callback_data' => 'на_публикацию'
							]
						],
						[
							[
								'text' => 'Изменить подробности',
								'callback_data' => 'изменить_подробности'
							]
						],
						[
							[
								'text' => 'В начало',
								'callback_data' => 'старт'
							]
						]
					]
				];			
				
				//$bot->sendMessage($from_id, $текст, markdown, $inLine);		
				
				if ($формат_файла == 'фото') {
					
					$публикация = $bot->sendPhoto($from_id, $файлАйди, $текст, markdown, $inLine);
						
				}elseif ($формат_файла == 'видео') {
					
					$публикация = $bot->sendVideo($from_id, $файлАйди, $текст, markdown, $inLine);
					
				}
				
			}
		
		}else throw new Exception("Или нет заказа или больше одного..");			
	
	}else throw new Exception("Нет такого заказа..");

}




// отправка клиентом введённой информации 
function _на_публикацию() {
	
	global $callback_query_id, $callback_from_id, $from_id, $bot, $message_id;
	
	if (!$callback_from_id) $callback_from_id = $from_id;	
	
	$давно = _последняя_публикация();
	
	if ($давно) {
		
		_отправка_лота_админам();

		_ожидание_результата();

		_отправка_сообщений_инфоботу();	
		
		_запись_в_таблицу_маркет($callback_from_id, 'date', time());
		
		$inLine = [
			'inline_keyboard' => [
				[
					[
						'text' => 'Отправлено',
						'callback_data' => 'отправлено'
					]
				],
				[
					[
						'text' => 'В начало',
						'callback_data' => 'старт'
					]
				]
			]
		];
		
		$bot->editMessageReplyMarkup($callback_from_id, $message_id, null, $inLine);
		
	}else $bot->answerCallbackQuery($callback_query_id, "Безоплатно можно публиковать только раз в сутки один лот!", true);

}



// возврат к вводу подробной информации о лоте
function _изменить_подробности() {

	_опишите_подробно('хорошо');

}



// КОНЕЦ - клиент ожидает решения администрации
function _ожидание_результата() {

	global $bot, $from_id, $callback_from_id;
	
	if (!$callback_from_id) $callback_from_id = $from_id;
	
	$reply = "|\n|\n|\n|\n|\n|\n|\n|\nОжидайте результат.\n\n(После публикации Вашего лота".
		" Вы будете об этом уведомлены, в случае отказа Вас также, уведомят. Ожидайте..)";
	
	$bot->sendMessage($callback_from_id, $reply);

}




// отправка лота администрации на проверку
function _отправка_лота_админам() {
	
	global $table_market, $from_id, $bot, $mysqli, $imgBB, $admin_group;	
	global $callback_from_username, $from_username, $callback_from_id, $from_id;
	
	if (!$callback_from_username) $callback_from_username = $from_username;
	
	if (!$callback_from_id) $callback_from_id = $from_id;
	
	$кнопки = [
		[ [ 'text' => 'Опубликовать',
			'callback_data' => 'опубликовать:'.$callback_from_id ] ],
		[ [ 'text' => 'PRIZMarket доверяет',
			'callback_data' => 'доверяет:'.$callback_from_id ] ],
		[ [ 'text' => 'PRIZMarket НЕ доверяет',
			'callback_data' => 'не_доверяет:'.$callback_from_id ] ],
		[ [ 'text' => 'Редактировать название',
			'callback_data' => 'редактировать_название:'.$callback_from_id ] ],
	];	
		
	$запрос = "SELECT * FROM {$table_market} WHERE id_client={$callback_from_id} AND id_zakaz=0";
		
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
					
					$кнопки = array_merge($кнопки, [
						[ [ 'text' => 'Редактировать ссылку',
							'callback_data' => 'редактировать_ссылку:'.$callback_from_id ] ],
					]);	
					
				}else $название_для_подробностей = str_replace('_', '\_', $название);
				
				$кнопки = array_merge($кнопки, [
					[ [ 'text' => 'Редактировать хештеги',
						'callback_data' => 'редактировать_хештеги:'.$callback_from_id ] ],
					[ [ 'text' => 'Редактировать подробности',
						'callback_data' => 'редактировать_подробности:'.$callback_from_id ] ],
					[ [ 'text' => 'Редактировать фото',
						'callback_data' => 'редактировать_фото:'.$callback_from_id ] ],
					[ [ 'text' => 'ОТКАЗАТЬ',
						'callback_data' => 'отказать:'.$callback_from_id ] ],
				]);
	
				$inLine = [ 'inline_keyboard' => $кнопки ];
				
				$куплю_или_продам = $строка['kuplu_prodam'];								
				$валюта = $строка['valuta'];				
				$хештеги_города = $строка['gorod'];				
				$юзера_имя = $строка['username'];				
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
				
				if ($формат_файла == 'фото') {
				
					$Объект_файла = $bot->getFile($файлАйди);		
		
					$ссыль_на_файл = $bot->fileUrl . $bot->token;	
					
					$ссыль = $ссыль_на_файл . "/" . $Объект_файла['file_path'];		
					
					$результат = $imgBB->upload($ссыль);					
					
					if ($результат) {		
						
						$imgBB_url = $результат['url'];		

						_запись_в_таблицу_маркет($callback_from_id, 'url_tgraph', $imgBB_url);
						
					}else throw new Exception("Не смог выложить пост..");					
					
					$реплика = "[_________]({$imgBB_url})\n{$текст}";	
					
					$КаналИнфо = $bot->sendMessage($admin_group, $реплика, markdown, $inLine);	
				
				}else $КаналИнфо = $bot->sendMessage($admin_group, $текст, markdown, $inLine);
				
				if (!$КаналИнфо) throw new Exception("Не смог в админке опубликовать заказ..");
				
			}
		
		}else throw new Exception("Или нет заказа или больше одного..");
	
	}else throw new Exception("Нет такого заказа..");	

}




// замена админом названия лота
function _редактировать_название($id_client) {

	global $bot, $callback_query_id;

	_ожидание_ввода('замена_названия', $id_client);
	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новый текст с названием.", true);	
	
}



// замена админом ссылки в названии лота
function _редактировать_ссылку($id_client) {

	global $bot, $callback_query_id;

	_ожидание_ввода('замена_ссылки', $id_client);
	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новую ссылку.", true);	
	
}



// замена админом хештегов
function _редактировать_хештеги($id_client) {

	global $bot, $callback_query_id;

	_ожидание_ввода('замена_хештегов', $id_client);
	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новый текст с хештегами.", true);	
	
}



// замена админом текста с подробностями
function _редактировать_подробности($id_client) {

	global $bot, $callback_query_id;

	_ожидание_ввода('замена_подробностей', $id_client);
	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новый текст подробностей.", true);	
	
}



// замена админом фото у лота
function _редактировать_фото($id_client) {

	global $bot, $callback_query_id;

	_ожидание_ввода('замена_фото', $id_client);
	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новое фото.", true);	
	
}



// вывод на канал подробности уже готового лота
function _вывод_лота_на_каналы($id_client, $номер_лота = 0) {

	global $table_market, $bot, $chat_id, $mysqli, $imgBB, $channel_podrobno, $channel_market;
	global $таблица_медиагруппа, $channel_media_market, $master, $message_id, $admin_group, $три_часа;

	_очистка_таблицы_ожидание();
	
	$запрос = "SELECT * FROM {$table_market} WHERE id_client={$id_client} AND id_zakaz='{$номер_лота}'";
		
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
				$юзера_имя = $строка['username'];				
				$доверие = $строка['doverie'];
				$категория = $строка['otdel'];				
				$подробности = $строка['podrobno'];			
				
				$хештеги = "{$куплю_или_продам}\n\n{$категория}\n▪️";				
				$хештеги = str_replace('_', '\_', $хештеги);
				
				$текст = "\n▪️{$валюта}\n▪️{$хештеги_города}\n▪️{$юзера_имя}";
				
				$текст = str_replace('_', '\_', $текст);
								
				$количество = substr_count($подробности, '[');
				
				if ($количество == 0) {
					
					$подробности = str_replace('_', '\_', $подробности);
					
				}			
				
				$текст .= "\n\n{$подробности}"; 
								
				$текст = "{$хештеги}{$название_для_подробностей}{$текст}";
				
				$imgBB_url = $строка['url_tgraph'];	

				if ($imgBB_url) {								
					$реплика = "[_________]({$imgBB_url})\n{$текст}";					
				}else $реплика = $текст;		
				
				$ссылка_инфобота = $строка['url_info_bot'];				
				
				$кнопки = [
					[
						[
							'text' => 'О пользователе',
							'url' => $ссылка_инфобота
						],
						[
							'text' => 'ГАРАНТ',
							'url' => 'https://t.me/podrobno_s_PZP/1044'
						]
					]
				];
				
				if ($строка['foto_album'] == '1') {
	
					$ссылка_на_канал_медиа = _публикация_на_канале_медиа($id_client);					
					
					if ($ссылка_на_канал_медиа) {
					
						$кнопки = array_merge($кнопки, [
							[
								[
									'text' => 'Фото',
									'url' => $ссылка_на_канал_медиа
								]
							]
						]);

					}
				
				}
				
				$кнопки = array_merge($кнопки, [
					[
						[
							'text' => 'INSTAGRAM PRIZMarket',
							'url' => 'https://www.instagram.com/prizm_market_inst'
						],
						[
							'text' => 'PZMarket bot',
							'url' => 'https://t.me/Prizm_market_bot'
						]
					],
					[
						[
							'text' => 'Заказать пост',
							'url' => 'https://t.me/Zakaz_prizm_bot'
						],
						[
							'text' => 'Канал PRIZMarket',
							'url' => 'https://t.me/prizm_market/'
						]
					]
				]);
				
				$inLine = ['inline_keyboard' => $кнопки];				
				
				$КаналИнфо = $bot->sendMessage($channel_podrobno, $реплика, markdown, $inLine);		
				
			}
			
				
			if ($КаналИнфо) {				
					
				$id_zakaz = $КаналИнфо['message_id'];
				
				if ($ссылка_на_канал_медиа) {
				
					_запись_в_таблицу_медиагрупа($id_client, $id_zakaz, $ссылка_на_канал_медиа);
					
				}
					
				$ссыль_на_подробности = "https://t.me/{$КаналИнфо['chat']['username']}/{$id_zakaz}";
				
				_запись_в_таблицу_маркет($id_client, 'id_zakaz', $id_zakaz);

				if (!$ссыль_в_названии) {
					
					_запись_в_таблицу_маркет($id_client, 'url_nazv', $ссыль_на_подробности);			
						
					$ссыль_в_названии = $ссыль_на_подробности;
						
				}
					
				_запись_в_таблицу_маркет($id_client, 'url_podrobno', $ссыль_на_подробности);
					
				$inLine = [
					'inline_keyboard' => [
						[
							[
								'text' => 'Подробнее',
								'url' => $ссыль_на_подробности
							]
						]
					]
				];				
					
				$текст = "\n▪️{$валюта}\n▪️{$хештеги_города}\n▪️{$юзера_имя}";
					
				$текст = str_replace('_', '\_', $текст);
					
				if ($доверие) $текст .= "\n  лот {$id_zakaz}\n✅ PRIZMarket доверяет❗️"; 
				else $текст .= "\n   лот {$id_zakaz}";

				$текст = "{$хештеги}[{$название}]({$ссыль_в_названии}){$текст}";
					
				if ($формат_файла == 'фото') {
					
					$публикация = $bot->sendPhoto($admin_group, $файлАйди, $текст, markdown, $inLine);
						
				}elseif ($формат_файла == 'видео') {
					
					$публикация = $bot->sendVideo($admin_group, $файлАйди, $текст, markdown, $inLine);
					
				}
					
				if ($публикация) {					
					
					_запись_в_таблицу_маркет($id_client, 'status', "одобрен");
						
				}else throw new Exception("Не смог отправить лот в админку.");	
					
			}else throw new Exception("Не отправился лот на канал Подробности..");			
			
			
		
		}else throw new Exception("Или нет заказа или больше одного..");			
	
	}else throw new Exception("Нет такого заказа..");
	
	
	
	$inLine = [
		'inline_keyboard' => [
			[
				[
					'text' => 'Опубликованно в подробностях',
					'url' => $ссыль_на_подробности
				]
			]
		]
	];
	
	$bot->editMessageReplyMarkup($chat_id, $message_id, null, $inLine);

}



// публикация альбома с фотографиями на отдельном канале
function _публикация_на_канале_медиа($номер_клиента) {
	
	global $bot, $master, $таблица_медиагруппа, $mysqli, $channel_media_market;
	
	$ответ = false;
	
	$запрос = "SELECT * FROM {$таблица_медиагруппа} WHERE id_client={$номер_клиента} AND id='0'";
		
	$результат = $mysqli->query($запрос);
		
	if ($результат) {
			
		if ($результат->num_rows > 1) {
			
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);
				
			$файл_медиа = [];
				
			foreach ($результМассив as $строка) {
					
				if ($строка['format_file'] == 'фото') {
						
					$тип = 'photo';
						
				}elseif ($строка['format_file'] == 'видео') {
					
					$тип = 'video';
					
				}
						
				$медиа = $строка['file_id'];
						
				$файл_медиа = array_merge($файл_медиа, [						
					[			
						'type' => $тип,							
						'media' => $медиа			
					]							
				]);
					
			}
			
			$результат = $bot->sendMediaGroup($channel_media_market, $файл_медиа);
	
			//$bot->sendMessage($master, $bot->PrintArray($результат));
				
			if ($результат) {		
				
				$ответ = "https://t.me/{$результат[0]['chat']['username']}/{$результат[0]['message_id']}";	

			}
			
		}else $bot->sendMessage($master, "Или нет заказа или меньше двух в {$таблица_медиагруппа}");
			
	}else $bot->sendMessage($master, "Нет такого заказа в {$таблица_медиагруппа}");	
	
	return $ответ;	

}


// отправка сообщений инфоботу на его канал, для формирования ссылки "о клиенте"
function _отправка_сообщений_инфоботу() {
	
	global $bot, $channel_info;
	global $callback_from_username, $from_username, $callback_from_id, $from_id;
	
	if (!$callback_from_username) $callback_from_username = $from_username;
	
	if (!$callback_from_id) $callback_from_id = $from_id;
	
	$bot->sendMessage($channel_info, "@".$callback_from_username);
	
	$bot->sendMessage($channel_info, $callback_from_id);	
	
}




// отметка доверием (PRIZMarket доверяет)
function _доверяет($id) {

	global $bot, $callback_query_id;
	
	_запись_в_таблицу_маркет($id, 'doverie', '1');
	
	$bot->answerCallbackQuery($callback_query_id, "Хорошо, отмечен доверием!");

}




// ОТМЕНА отметки доверием (PRIZMarket доверяет)
function _не_доверяет($id) {

	global $bot, $callback_query_id;
	
	_запись_в_таблицу_маркет($id, 'doverie', '0');
	
	$bot->answerCallbackQuery($callback_query_id, "ОТМЕНА отметки доверием!");

}





// отметка доверием (PRIZMarket доверяет)
function _отказать($id) {

	global $bot, $callback_query_id, $chat_id, $message_id;

	$bot->sendMessage($id, "Вам отказанно. [Читайте правила](https://t.me/podrobno_s_PZP/562).\n\n/start 👈🏻 в главное меню!", markdown, true);
	
	if (_удалить_лот($id)) {
		
		$inLine = [
			'inline_keyboard' => [
				[
					[
						'text' => 'Отказанно',
						'callback_data' => 'отказанно'
					]
				]
			]
		];
		
		$bot->editMessageReplyMarkup($chat_id, $message_id, null, $inLine);

	}

}


// удаление лота
function _удалить_лот($айди_клиента, $номер_лота = '0') {
	
	global $bot, $mysqli, $table_market;
	
	$query = "DELETE FROM ".$table_market." WHERE id_client=".$айди_клиента." AND id_zakaz={$номер_лота}";	
	
	if ($result = $mysqli->query($query)) {
	
		return true;
		
	}else throw new Exception("Не смог изменить таблицу {$table_market}");	
	
}




// возврат лотов из базы по номеру клиента для инлайн режима
function _возврат_лотов_для_инлайн($id_client) {

	global $table_market, $bot, $mysqli, $master;
	
	$response = false;
	
	$запрос = "SELECT * FROM {$table_market} WHERE id_client={$id_client} AND id_zakaz>0";
		
	$результат = $mysqli->query($запрос);
	
	if ($результат) {
		
		if ($результат->num_rows > 0) {
		
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);
			
			$i = 1;
			
			$InlineQueryResult = [];
			
			foreach ($результМассив as $строка) {
			
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
				//$подробности = $строка['podrobno'];	
				$ссыль_на_подробности = $строка['url_podrobno'];
				
				//$номер_лота =  substr(strrchr($ссыль_на_подробности, "/"), 1);
				// хи-хи
				
				$номер_лота = $строка['id_zakaz'];
				
				$photo_url = $строка['url_tgraph'];	
						
				$inLine = [
					'inline_keyboard' => [
						[
							[
								'text' => 'Подробнее',
								'url' => $ссыль_на_подробности
							]
						]
					]
				];				
				
				$хештеги = "{$куплю_или_продам}\n\n{$категория}\n▪️";				
				$хештеги = str_replace('_', '\_', $хештеги);
				
				$текст_после_названия = "\n▪️{$валюта}\n▪️{$хештеги_города}\n▪️{$юзера_имя}\n  лот {$номер_лота}";					
				$текст_после_названия = str_replace('_', '\_', $текст_после_названия);
					
				if ($доверие) $текст_после_названия .= "\n✅ PRIZMarket доверяет❗️"; 
					
				$текст = "{$хештеги}[{$название}]({$ссыль_в_названии}){$текст_после_названия}";
					
				if ($формат_файла == 'фото') {
				
					$InlineQueryResult = array_merge($InlineQueryResult, [
						[
							'type' => 'photo',
							'id' => $id_client."_".$i,
							'photo_url' => $photo_url,
							'thumb_url' => $photo_url,							
							'title' => $куплю_или_продам,
							'description' => $название,
							'caption' => $текст,
							'parse_mode' => 'markdown',
							'reply_markup' => $inLine,							
						],
					]);			
						
				}elseif ($формат_файла == 'видео') {
					
					$Объект_файла = $bot->getFile($файлАйди);		
		
					$ссыль_на_файл = $bot->fileUrl . $bot->token;	
					
					$ссыль = $ссыль_на_файл . "/" . $Объект_файла['file_path'];
					
					$InlineQueryResult = array_merge($InlineQueryResult, [
						[						
							'type' => 'video',
							'id' => $id_client."_".$i,
							'video_url' => $ссыль,
							'mime_type' => 'video/mp4', // или 'text/html'
							'thumb_url' => $ссыль,
							'title' => $куплю_или_продам,					
							'caption' => $текст,
							'description' => $название,
							'parse_mode' => 'markdown',
							'reply_markup' => $inLine,	
							
						],
					]);				
						
				}
				
				$i++;
				
			}
			
			$response = $InlineQueryResult;
		
		}else throw new Exception("Или нет заказа или больше одного..");			
	
	}else throw new Exception("Нет такого заказа..");	
	
	return $response;
	
}






// отправка лота администратору для редактирования
function _редактор_лотов($номер_лота) {
	
	global $table_market, $chat_id, $bot, $mysqli, $imgBB, $admin_group, $HideKeyboard;	
	global $callback_from_username, $from_username, $callback_from_id, $from_id;
	
	if (!$callback_from_username) $callback_from_username = $from_username;
	
	if (!$callback_from_id) $callback_from_id = $from_id;
	
	$inLine = [
		'inline_keyboard' => [
			[
				[
					'text' => 'Применить!',
					'callback_data' => 'показать_редакт:'.$номер_лота
				]
			],
			[
				[
					'text' => 'PRIZMarket доверяет',
					'callback_data' => 'доверяет_редакт:'.$номер_лота
				]
			],
			[
				[
					'text' => 'PRIZMarket НЕ доверяет',
					'callback_data' => 'не_доверяет_редакт:'.$номер_лота
				]
			],
			[
				[
					'text' => 'Редактировать название',
					'callback_data' => 'название_редакт:'.$номер_лота
				]
			],
			[
				[
					'text' => 'Редактировать ссылку',
					'callback_data' => 'ссылку_редакт:'.$номер_лота
				]
			],
			[
				[
					'text' => 'Редактировать хештеги',
					'callback_data' => 'хештеги_редакт:'.$номер_лота
				]
			],
			[
				[
					'text' => 'Редактировать подробности',
					'callback_data' => 'подробности_редакт:'.$номер_лота
				]
			],
			[
				[
					'text' => 'Редактировать фото',
					'callback_data' => 'фото_редакт:'.$номер_лота
				]
			]
		]
	];
		
	$запрос = "SELECT * FROM {$table_market} WHERE id_zakaz={$номер_лота}";
		
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
				$юзера_имя = $строка['username'];				
				$категория = $строка['otdel'];				
				
				$подробности = $строка['podrobno'];				
				
				$хештеги = "{$куплю_или_продам}\n\n{$категория}\n▪️";				
				$хештеги = str_replace('_', '\_', $хештеги);
				
				$текст = "\n▪️{$валюта}\n▪️{$хештеги_города}\n▪️{$юзера_имя}";				
				$текст = str_replace('_', '\_', $текст);
								
				$количество = substr_count($подробности, '[');
				
				if ($количество == 0) {
					
					$подробности = str_replace('_', '\_', $подробности);
					
				}else {
					
					$подробности = str_replace('[', '\[', $подробности);
					
				}
				
				$текст .= "\n\n{$подробности}"; 					
				
				if ($ссыль_в_названии) {
					
					$ссыль_в_названии = str_replace('_', '\_', $ссыль_в_названии);
					
					$текст = "{$хештеги}{$название_для_подробностей}\n({$ссыль_в_названии}){$текст}";			
					
				}else $текст = "{$хештеги}{$название_для_подробностей}{$текст}";
				
				$imgBB_url = $строка['url_tgraph'];
				
				$реплика = "[_________]({$imgBB_url})\n{$текст}";	
				
				$bot->sendMessage($chat_id, "Держи *Мастер*.", markdown, $HideKeyboard);					
				
				$КаналИнфо = $bot->sendMessage($chat_id, $реплика, markdown, $inLine);	
				
				if (!$КаналИнфо) throw new Exception("Не смог админу показать лот для редактирования. (_редактор_лотов)");
				
			}
		
		}else $bot->sendMessage($chat_id, "Нет такого заказа.. (_редактор_лотов)");
	
	}else throw new Exception("Не смог проверить заказ.. (_редактор_лотов)");	

}


// Функция для редактирования таблицы маркет
function _редакт_таблицы_маркет($номер_лота, $имя_столбца, $действие) {

	global $table_market, $mysqli;
		
	$query ="UPDATE {$table_market} SET {$имя_столбца}='{$действие}' WHERE id_zakaz={$номер_лота}";
		
	$result = $mysqli->query($query);
			
	if (!$result) throw new Exception("Не смог обновить запись в таблице (_редакт_таблицы_маркет)");
	
}


// Показ админу отредактированного лота
function _показать_редакт($номер_лота) {	
	global $bot, $mysqli, $table_market, $callback_query_id, $callback_from_id, $from_id, $master;	
	if (!$callback_from_id) $callback_from_id = $from_id;	
	
	_редакт_лота_на_канале_подробности($номер_лота);	
	
	$запрос = "SELECT * FROM {$table_market} WHERE id_zakaz='{$номер_лота}'";		
	$результат = $mysqli->query($запрос);	
	if ($результат) {		
		if ($результат->num_rows == 1) {		
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);			
			foreach ($результМассив as $строка) {			
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
				//$подробности = $строка['podrobno'];	
				$ссыль_на_подробности = $строка['url_podrobno'];										
				$inLine = [ 'inline_keyboard' => 
					[ [ [ 'text' => 'Подробнее',
						  'url' => $ссыль_на_подробности ] ] ] ];								
				$хештеги = "{$куплю_или_продам}\n\n{$категория}\n▪️";				
				$хештеги = str_replace('_', '\_', $хештеги);				
				$текст_после_названия = "\n▪️{$валюта}\n▪️{$хештеги_города}\n▪️{$юзера_имя}\n  лот {$номер_лота}";
				$текст_после_названия = str_replace('_', '\_', $текст_после_названия);					
				if ($доверие) $текст_после_названия .= "\n✅ PRIZMarket доверяет❗️"; 					
				$текст = "{$хештеги}[{$название}]({$ссыль_в_названии}){$текст_после_названия}";				
				if ($формат_файла == 'фото') {					
					$публикация = $bot->sendPhoto($callback_from_id, $файлАйди, $текст, markdown, $inLine);	
				}elseif ($формат_файла == 'видео') {						
					$публикация = $bot->sendVideo($callback_from_id, $файлАйди, $текст, markdown, $inLine);	
				}						
			}		
		}else $bot->sendMessage($master, "Или нет заказа или больше одного.. (_показать_редакт)");	
	}else throw new Exception("Не смог найти заказ.. (_показать_редакт)");	
	$bot->answerCallbackQuery($callback_query_id, "Держи Мастер!");		
}



// изменением админом отметки доверием (PRIZMarket доверяет)
function _доверяет_редакт($номер_лота) {
	
	global $bot, $callback_query_id;
	
	_редакт_таблицы_маркет($номер_лота, 'doverie', '1');
	
	$bot->answerCallbackQuery($callback_query_id, "Хорошо, отмечен доверием!");	
	
}


// ОТМЕНА отметки доверием (PRIZMarket доверяет)
function _не_доверяет_редакт($номер_лота) {

	global $bot, $callback_query_id;
	
	_редакт_таблицы_маркет($номер_лота, 'doverie', '0');
	
	$bot->answerCallbackQuery($callback_query_id, "ОТМЕНА отметки доверием!");

}


// замена админом названия у опубликованного лота
function _название_редакт($номер_лота) {

	global $bot, $callback_query_id;

	_ожидание_ввода('название_редакт', $номер_лота);
	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новый текст с названием.");	
	
}


// замена админом ссылки в названии у опубликованного лота
function _ссылку_редакт($номер_лота) {

	global $bot, $callback_query_id;

	_ожидание_ввода('ссылку_редакт', $номер_лота);
	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новую ссылку.");	
	
}


// замена админом хештегов у опубликованного лота
function _хештеги_редакт($номер_лота) {

	global $bot, $callback_query_id;

	_ожидание_ввода('хештеги_редакт', $номер_лота);
	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новый текст с хештегами.");	
	
}


// замена админом подробностей у опубликованного лота
function _подробности_редакт($номер_лота) {

	global $bot, $callback_query_id;

	_ожидание_ввода('подробности_редакт', $номер_лота);
	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новый текст с подробностями.");	
	
}



// замена админом подробностей у опубликованного лота
function _фото_редакт($номер_лота) {

	global $bot, $callback_query_id;

	_ожидание_ввода('фото_редакт', $номер_лота);
	
	$bot->answerCallbackQuery($callback_query_id, "Пришли мне новое фото.");	
	
}




// именение содержимого лота на канале подробности
function _редакт_лота_на_канале_подробности($номер_лота) {

	global $table_market, $bot, $chat_id, $mysqli, $imgBB, $channel_podrobno, $channel_market;
	global $таблица_медиагруппа, $channel_media_market, $master, $message_id, $admin_group, $три_часа;	
	$запрос = "SELECT * FROM {$table_market} WHERE id_zakaz='{$номер_лота}'";		
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
				$юзера_имя = $строка['username'];				
				$доверие = $строка['doverie'];
				$категория = $строка['otdel'];				
				$подробности = $строка['podrobno'];							
				$хештеги = "{$куплю_или_продам}\n\n{$категория}\n▪️";				
				$хештеги = str_replace('_', '\_', $хештеги);
				$текст = "\n▪️{$валюта}\n▪️{$хештеги_города}\n▪️{$юзера_имя}";				
				$текст = str_replace('_', '\_', $текст);								
				$количество = substr_count($подробности, '[');				
				if ($количество == 0) {					
					$подробности = str_replace('_', '\_', $подробности);					
				}							
				$текст .= "\n\n{$подробности}"; 						
				$текст = "{$хештеги}{$название_для_подробностей}{$текст}";				
				$imgBB_url = $строка['url_tgraph'];	
				if ($imgBB_url) {								
					$реплика = "[_________]({$imgBB_url})\n{$текст}";					
				}else $реплика = $текст;						
				$ссылка_инфобота = $строка['url_info_bot'];								
				$кнопки = [
					[
						[
							'text' => 'О пользователе',
							'url' => $ссылка_инфобота
						],
						[
							'text' => 'ГАРАНТ',
							'url' => 'https://t.me/podrobno_s_PZP/1044'
						]
					]
				];		
				if ($строка['foto_album'] == '1') {					
					$запрос = "SELECT url FROM {$таблица_медиагруппа} WHERE id='{$номер_лота}'";			
					$результат = $mysqli->query($запрос);	
					if ($результат) {						
						if ($результат->num_rows > 0) {						
							$результМассив = $результат->fetch_all(MYSQLI_ASSOC);						
							$ссылка_на_канал_медиа = $результМассив[0]['url'];
						}						
						if ($ссылка_на_канал_медиа) {							
							$кнопки = array_merge($кнопки, [
								[
									[
										'text' => 'Фото',
										'url' => $ссылка_на_канал_медиа
									]
								]
							]);
						}					
					}						
				}		
				$кнопки = array_merge($кнопки, [
					[
						[
							'text' => 'INSTAGRAM PRIZMarket',
							'url' => 'https://www.instagram.com/prizm_market_inst'
						],
						[
							'text' => 'PZMarket bot',
							'url' => 'https://t.me/Prizm_market_bot'
						]
					],
					[
						[
							'text' => 'Заказать пост',
							'url' => 'https://t.me/Zakaz_prizm_bot'
						],
						[
							'text' => 'Канал PRIZMarket',
							'url' => 'https://t.me/prizm_market/'
						]
					]
				]);				
				$inLine = ['inline_keyboard' => $кнопки];		
				try {
					$изменил = $bot->editMessageText($channel_podrobno, $номер_лота, $реплика, null, markdown, false, $inLine);						
				}catch(Exception $e) {
					$изменил = false;
				}
			}			
		}else $bot->sendMessage($master, "Или нет заказа или больше одного.. (_редакт_лота_на_канале_подробности)");	
	}else throw new Exception("Не смог найти заказ.. (_редакт_лота_на_канале_подробности)");		
	if ($изменил) $bot->sendMessage($chat_id, "Изменил лот на канале 'Подробности'");	
}



function _список_всех_лотов($юзернеим = null) {	
	global $bot, $table_market, $mysqli, $callback_from_id, $from_id, $chat_id;	
	if (!$callback_from_id) $callback_from_id = $from_id;
	$айди_клиента = _дай_айди($юзернеим);
	if ($айди_клиента) {
		$запрос = "SELECT id_zakaz, kuplu_prodam, nazvanie FROM {$table_market} WHERE id_client={$айди_клиента} AND id_zakaz>0";	
	}else $запрос = "SELECT id_zakaz, kuplu_prodam, nazvanie FROM {$table_market} WHERE id_zakaz>0";
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
						'callback_data' => "покажи:{$строка['id_zakaz']}"
					]]]);			
				}					
				$кнопки = array_merge($кнопки, [[[
						'text' => "*** в Главное меню ***",
						'callback_data' => "старт"
					]]]);			
				$inLine = [			
					'inline_keyboard' => $кнопки				
				];			
				$реплика = "Выберите лот для просмотра.";						
				$bot->sendMessage($chat_id, $реплика, null, $inLine);	
			}else $bot->sendMessage($chat_id, $количество);		
		}else $bot->sendMessage($chat_id, "Нет такой записи в БД");		
	}else throw new Exception("Не получился запрос к БД (_список_всех_лотов)");
}


?>