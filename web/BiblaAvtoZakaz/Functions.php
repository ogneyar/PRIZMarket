<?
/* Список всех функций:
**
** _start_AvtoZakazBota
** _info_AvtoZakazBota
** exception_handler
** _existence
**
** _создать
** _куплю
** _продам
** _продам_куплю
** _запись_в_таблицу_маркет
** _ожидание_ввода
** _очистка_таблицы_ожидание
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
** _отправьте_файл
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
				]
			]
		]
	];
	
	$reply = "Это Бот для подачи заявки на публикацию вашего лота на канале [Покупки на PRIZMarket]".
		"(https://t.me/prizm_market)\n\nПошагово пройдите по всем пунктам. Начните с нажатия кнопки ".
		"'Создать заявку'.";

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
			  `url_tgraph`
			) VALUES (
			  '{$callback_from_id}', '', '', '', '', '', '', '@{$callback_from_username}', '', '', '', '', '', '', '', ''
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
	
	global $bot, $message_id, $callback_query_id, $callback_from_id;
	
	if ($валюта) {
		
		$валюта.= " / PZM";
		
	}else {
		
		$валюта = "PZM";
		
	}
	
	_запись_в_таблицу_маркет('valuta', $валюта);
	
	_ожидание_ввода('gorod', 'valuta');
	
	$bot->answerCallbackQuery($callback_query_id, "Ожидаю ввода местонахождения!");	

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
	
	$reply = "Введите хештеги местонахождения: (не больше трёх)\n\n(#Весь_мир #Россия #Ростов_на_Дону)";
	
	$bot->sendMessage($callback_from_id, $reply, null, $ReplyKey);		

}


//
function _отправьте_файл() {

	global $bot, $chat_id;
	
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
	
	$reply = "Отправьте один файл. \n\nФото или видео. \n\nЕсли пришлёте больше, я приму только первый файл, остальные проигнорирую.\n(учтите: видео должно быть коротким, не более 5 МБ)";
	
	$bot->sendMessage($chat_id, $reply, null, $ReplyKey);		

}


?>
