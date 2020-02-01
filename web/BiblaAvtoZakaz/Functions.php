<?
/* Список всех функций:
**
** _start_AvtoZakazBota
** _info_AvtoZakazBota
** exception_handler
** _existence
**
** _создать
** _повторить
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
** _ожидание_результата
** _отправка_лота_админам
** _вывод_лота_на_каналы
**
**
**
*/

// функция старта бота ИНФОРМАЦИЯ О ПОЛЬЗОВАТЕЛЯХ
function _start_AvtoZakazBota() {		

	global $bot, $chat_id, $from_first_name, $HideKeyboard;
	
	$bot->sendMessage($chat_id, "Добро пожаловать, *".$from_first_name."*!", markdown, $HideKeyboard);

    _info_AvtoZakazBota();	
	
	exit('ok');
	
}

// Краткая информация, перед началом работы с ботом
function _info_AvtoZakazBota() {

	global $bot, $chat_id;
	
	$inLine_sozdanie = [
		'inline_keyboard' => [
			[
				[
					'text' => 'Создать заявку',
					'callback_data' => 'создать'
				],
				[
					'text' => 'Повторить',
					'callback_data' => 'повторить'
				]
			]
		]
	];
	
	$reply = "Это Бот для подачи заявки на публикацию вашего лота на канале [Покупки на PRIZMarket]".
		"(https://t.me/prizm_market)\n\nДля подачи заявки на публикацию пошагово пройдите".
		" по всем пунктам. Начните с нажатия кнопки 'Создать заявку'.\nДля повтора уже имеющейся заявки - нажмите 'Повторить'.";

	$bot->sendMessage($chat_id, $reply, markdown, $inLine_sozdanie, null, true);

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


//------------------------------------------
// Начало создания заявки на публикацию лота 
//------------------------------------------
function _создать() {

	global $bot, $from_id, $message_id, $callback_query_id, $callback_from_id;	
	
	if (!$callback_from_id) {
	
		$callback_from_id = $from_id;
		
	}else $bot->answerCallbackQuery($callback_query_id, "Начнём!");
	
	_запись_в_таблицу_маркет();
	
	_очистка_таблицы_медиа();
	
	$inLine = [
		'inline_keyboard' => [
			[
				[
					'text' => '#продаю',
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



function _повторить() {
	
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
				
				if (strlen($название)>7) $название = substr($название, 0, 6);
				
				$кнопки .= [
					'text' => $строка['kuplu_prodam'] ." ". $название,
					'callback_data' => 'повтор:' . $строка['id_zakaz']
				];						
				
			}
						
			
			$inLine = [
				'inline_keyboard' => [
					[
						$кнопки
					]
				]
			];
			
			$реплика = "Выберите лот для повтора.";
			
			$bot->sendMessage($callback_from_id, "хз");
			
			$bot->sendMessage($callback_from_id, $реплика, null, $inLine);			
			
		}else throw new Exception("Нет такой записи в БД");
		
	}else throw new Exception("Не получился запрос к БД");

}



// Если клиент выбрал хештег КУПЛЮ
function _куплю() {

	_продам_куплю('#куплю');

}

// Если клиент выбрал хештег ПРОДАМ
function _продам() {

	_продам_куплю('#продам');

}

// Обработка выбранного действия ПРОДАМ/КУПЛЮ, с занесением в базу и ожиданием ввода НАЗВАНИЯ
function _продам_куплю($действие) {

	global $bot, $message_id, $callback_query_id, $callback_from_id;
	
	_запись_в_таблицу_маркет('kuplu_prodam', $действие);
	
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
function _запись_в_таблицу_маркет($имя_столбца = null, $действие = null) {

	global $table_market, $mysqli, $callback_from_id, $callback_from_username, $from_id, $from_username;
	
	if (!$callback_from_id) $callback_from_id = $from_id;		
	
	if (!$callback_from_username) $callback_from_username = $from_username;
	
	if (!$имя_столбца) {
	
		$query = "DELETE FROM {$table_market} WHERE id_client={$callback_from_id} AND status=''";
		
		$result = $mysqli->query($query);
		
		if ($result) {
			
			$query = "INSERT INTO {$table_market} (
			  `id_client`,
			  `id_zakaz`,
			  `kuplu_prodam`,
			  `nazvanie`,
			  `url_nazv`,
			  `valuta`,
			  `gorod`,
			  `username`,
			  `doverie`,
			  `otdel`,
			  `format_file`,
			  `file_id`,
			  `url_podrobno`,
			  `status`,
			  `podrobno`,
			  `url_tgraph`,
			  `foto_album`
			) VALUES (
			  '{$callback_from_id}', '', '', '', '', '', '', '@{$callback_from_username}', '', '', '', '', '', '', '', '', ''
			)";
						
			$result = $mysqli->query($query);
			
			if (!$result) throw new Exception("Не смог добавить запись в таблицу {$table_market}");
			
		}else throw new Exception("Не смог удалить запись в таблице {$table_market}");
		
	}else {
		
		$query ="UPDATE {$table_market} SET {$имя_столбца}='{$действие}' WHERE id_client={$callback_from_id} AND status=''";
		
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
	
	$bot->sendMessage($chat_id, $reply, null, $inLine);

}


// Нужна ли Вам Ваша ссылка, вшитая в названии?
function _не_нужна() {

	_выбор_валюты();

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
function _рубль() {

	_когда_валюта_выбрана('₽');

}

// Если выбрана валюта
function _доллар() {

	_когда_валюта_выбрана('$');

}

// Если выбрана валюта
function _евро() {

	_когда_валюта_выбрана('€');

}

// Если выбрана валюта
function _юань() {

	_когда_валюта_выбрана('¥');

}

// Если выбрана валюта
function _гривна() {

	_когда_валюта_выбрана('₴');

}

// Если выбрана валюта
function _фунт() {

	_когда_валюта_выбрана('£');

}

// Если выбрана валюта
function _призм() {

	_когда_валюта_выбрана();

}

// Когда уже выбрана валюта
function _когда_валюта_выбрана($валюта = null) {	
	
	if ($валюта) {
		
		$валюта.= " / PZM";
		
	}else {
		
		$валюта = "PZM";
		
	}
	
	_запись_в_таблицу_маркет('valuta', $валюта);
	
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
	
	$reply = "Введите хештеги местонахождения: (не больше трёх)\n\nПример:\n#Весь_мир #Россия #Ростов_на_Дону";
	
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
	
	global $bot, $chat_id;
	
	_очистка_таблицы_медиа();
	
	_запись_в_таблицу_маркет('foto_album', '1');
	
	_ожидание_ввода('foto_album', 'format_file');
	
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
	
	$reply = "Скиньте мне разом все фото, которые должны оказаться в альбоме (НЕ по одной фотке)";
	
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
function _запись_в_таблицу_медиагрупа() {
	
	global $таблица_медиагруппа, $mysqli, $callback_from_id, $from_id, $media_group_id, $file_id, $формат_файла;
	
	if (!$callback_from_id) $callback_from_id = $from_id;		
	
	$query = "INSERT INTO {$таблица_медиагруппа} (
		`id`,
		`id_client`,
		`media_group_id`,
		`format_file`,
		`file_id`
	) VALUES (
		'0', '{$callback_from_id}', '{$media_group_id}', '{$формат_файла}', '{$file_id}'
	)";
	
	$result = $mysqli->query($query);
	
	if (!$result) throw new Exception("Не смог добавить запись в таблицу {$таблица_медиагруппа}");
			
	return true;
	
}




function _не_нужен_альбом() {
	
	_очистка_таблицы_медиа();
	
	_опишите_подробно();
	
}


// функция предлагающая ввести ПОДРОБНую информацию о товаре/услуге
function _опишите_подробно() {

	global $bot, $chat_id;
	
	_ожидание_ввода('podrobno', 'foto_album');
	
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
		" Ваш лот. \n\nДостаточно подробно. \n\nНо, не переусердствуйте, ведь вы же не намерены переутомить своих".
		" потенциальных клиентов?";
	
	$bot->sendMessage($chat_id, $reply, null, $ReplyKey);
	
}



// КОНЕЦ - клиент ожидает решения администрации
function _ожидание_результата() {

	global $bot, $chat_id;
		
	$reply = "|\n|\n|\n|\n|\n|\n|\n|\nОжидайте результат.\n\n(После публикации Вашего лота".
		" Вы будете об этом уведомлены, в случае отказа Вас также, уведомят. Ожидайте..)";
	
	$bot->sendMessage($chat_id, $reply);

}




// отправка лота администрации на проверку
function _отправка_лота_админам() {

	global $bot, $callback_from_username, $from_username, $admin_group, $callback_from_id, $from_id;
	
	if (!$callback_from_username) $callback_from_username = $from_username;
	
	if (!$callback_from_id) $callback_from_id = $from_id;
	
	$inLine = [
		'inline_keyboard' => [
			[
				[
					'text' => 'Опубликовать',
					'callback_data' => 'опубликовать:'.$callback_from_id
				]
			]
		]
	];
	
	$reply = "Проверьте новый лот от клиента @{$callback_from_username}";
	
	$bot->sendMessage($admin_group, $reply, null, $inLine);

}






// вывод на канал подробности уже готового лота
function _вывод_лота_на_каналы($id_client, $номер_лота = 0) {

	global $table_market, $bot, $chat_id, $mysqli, $imgBB, $channel_podrobno, $channel_market;
	
	$from_id = $id_client; // это для функции _запись_в_таблицу_маркет()
	
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
					
				}else $название_для_подробностей = $название;
				
				$куплю_или_продам = $строка['kuplu_prodam'];				
				
				$валюта = $строка['valuta'];
				
				$хештеги_города = $строка['gorod'];
				
				$юзера_имя = $строка['username'];
				
				$подробности = $строка['podrobno'];
				
				$текст = "\n▪️{$валюта}\n▪️{$хештеги_города}\n▪️{$юзера_имя}\n\n{$подробности}";
				
				$текст = str_replace('_', '\_', $текст);
				
				$текст = "{$куплю_или_продам}\n\n▪️{$название_для_подробностей}{$текст}";			
				
				if ($формат_файла == 'фото') {
				
					$Объект_файла = $bot->getFile($файлАйди);		
		
					$ссыль_на_файл = $bot->fileUrl . $bot->token;	
					
					$ссыль = $ссыль_на_файл . "/" . $Объект_файла['file_path'];		
					
					$результат = $imgBB->upload($ссыль);					
					
					if ($результат) {		
						
						$imgBB_url = $результат['url'];		

						_запись_в_таблицу_маркет('url_tgraph', $imgBB_url);
						
					}else throw new Exception("Не смог выложить пост..");					
					
					$реплика = "[ ]({$imgBB_url}){$текст}";	
					
					$КаналИнфо = $bot->sendMessage($channel_podrobno, $реплика, markdown);		
				
				}else $КаналИнфо = $bot->sendMessage($channel_podrobno, $текст, markdown);
				
				if ($КаналИнфо) {
										
					$ссыль_на_подробности = "https://t.me/{$КаналИнфо['chat']['username']}/{$КаналИнфо['message_id']}";
					
					_запись_в_таблицу_маркет('id_zakaz', $КаналИнфо['message_id']);

					if (!$ссыль_в_названии) {
					
						_запись_в_таблицу_маркет('url_nazv', $ссыль_на_подробности);			
						
						$ссыль_в_названии = $ссыль_на_подробности;
						
					}
					
					_запись_в_таблицу_маркет('url_podrobno', $ссыль_на_подробности);
					
					_запись_в_таблицу_маркет('status', "одобрен");
					
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
					
					$текст = "{$куплю_или_продам}\n\n▪️[{$название}]({$ссыль_в_названии}){$текст}";
					
					if ($формат_файла == 'фото') {
					
						$публикация = $bot->sendPhoto($channel_market, $файлАйди, $текст, markdown, $inLine);
						
					}elseif ($формат_файла == 'видео') {
						
						$публикация = $bot->sendVideo($channel_market, $файлАйди, $текст, markdown, $inLine);
						
					}
					
					if ($публикация) {
						
						$реплика = "Лот опубликован.\n\nДля продолжения работы с ботом жмите /start";
						
						$bot->sendMessage($id_client, $реплика, markdown);	
						
					}else throw new Exception("Не смог выложить пост на основной канал.");			
					
				}else throw new Exception("Не отправился лот на канал Подробности..");			
			
			}
		
		}else throw new Exception("Или нет заказа или больше одного..");			
	
	}else throw new Exception("Нет такого заказа..");			

}








?>
