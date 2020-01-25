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


function _insert_kuplu_prodam() {

	global $bot, $chat_id;
	
	$inLine_dejstvie = [
		'inline_keyboard' => [
			[
				[
					'text' => '#продаю',
					'callback_data' => 'продаю'
				],
				[
					'text' => '#куплю',
					'callback_data' => 'куплю'
				]
			]
		]
	];
	
	$reply = "Выберите действие:";

	$bot->sendMessage($chat_id, $reply, null, $inLine_dejstvie);

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
