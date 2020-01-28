<?

// функция старта бота ИНФОРМАЦИЯ О ПОЛЬЗОВАТЕЛЯХ
function _start_AvtoZakazBota() {		

	global $bot, $chat_id, $from_first_name, $HideKeyboard, $table_users;
	
	$bot->sendMessage($chat_id, "Добро пожаловать, *".$from_first_name."*!", markdown, $HideKeyboard);

    _info_AvtoZakazBota();	
	
	exit('ok');
	
}

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

/*
	try {
	
		$bot->deleteMessage($chat_id, $message_id);
		
	}catch(Exception $e) {
	
		$bot->sendMessage($master, "Не смог удалить сообщение.\n - > chat_id = ".$chat_id);
	
	}
*/

}



function _куплю() {

	_продам_куплю('куплю');

}


function _продам() {

	_продам_куплю('продам');

}


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

/*	
	try {
	
		$bot->deleteMessage($chat_id, $message_id);
		
	}catch(Exception $e) {
	
		$bot->sendMessage($master, "Не смог удалить сообщение.\n - > chat_id = ".$chat_id);
	
	}
*/

}



function _запись_в_таблицу_маркет($имя_столбца = null, $действие = null) {

	global $table_market, $mysqli, $callback_from_id, $callback_from_username, $from_id, $from_username, $bot, $master;
	
	if (!$callback_from_id) {
	
		$callback_from_id = $from_id;
		
		$callback_from_username = $from_username;
		
	}
	
	
$bot->sendMessage($master, $from_username." bkb ".$callback_from_username);
	
	
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
	
	$reply = "|\n|\n|\n|\n|\n|\n|\n|\nНужна ли Вам Ваша ссылка в названии?\n\nЕсли не знаете или не поймёте о чём речь, нажмите 'НЕТ'.";
	
	$bot->sendMessage($chat_id, $reply, null, $inLine);

}



function _да_нужна() {}

function _не_нужна() {}


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





?>
