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

	global $bot, $chat_id, $message_id, $callback_query_id, $callback_from_id;	
	
	$bot->answerCallbackQuery($callback_query_id, "Начнём!");
	
	_запись_в_таблицу_маркет($callback_from_id);
	
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
	
	$bot->sendMessage($chat_id, $reply, null, $inLine);

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

function _запись_в_таблицу_маркет($айди_клиента, $имя_столбца = null, $действие = null) {

	global $table_market, $mysqli;
	
	if (!$имя_столбца) {
	
		$query = "DELETE FROM {$table_market} WHERE id_client={$айди_клиента} AND status=''";
		
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
			  '{$айди_клиента}', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''
			)";
						
			$result = $mysqli->query($query);
			
			if (!$result) throw new Exception("Не смог добавить запись в таблицу {$table_market}");
			
		}else throw new Exception("Не смог удалить запись в таблице {$table_market}");
		
	}else {
		
		$query ="UPDATE {$table_market} SET {$имя_столбца}='{$действие}' WHERE id_client={$айди_клиента} AND status=''";
		
		$result = $mysqli->query($query);
			
		if (!$result) throw new Exception("Не смог обновить запись в таблице {$table_market}");
		
		
	}

}


function _ожидание_ввода() {}


function _продам_куплю($действие) {

	global $bot, $chat_id, $message_id, $callback_query_id, $callback_from_id;
	
	_запись_в_таблицу_маркет($callback_from_id, 'kuplu_prodam', $действие);
	
	_ожидание_ввода();
	
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
	
	$bot->sendMessage($chat_id, $reply, null, $ReplyKey);	

/*	
	try {
	
		$bot->deleteMessage($chat_id, $message_id);
		
	}catch(Exception $e) {
	
		$bot->sendMessage($master, "Не смог удалить сообщение.\n - > chat_id = ".$chat_id);
	
	}
*/

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





?>
