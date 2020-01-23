<?

// функция старта бота ИНФОРМАЦИЯ О ПОЛЬЗОВАТЕЛЯХ
function _start_Zakaz_bota() {		

	global $bot, $chat_id, $from_first_name, $HideKeyboard, $table_users;
	
	$bot->add_to_database($table_users);
	
	$bot->sendMessage($chat_id, "Добро пожаловать, *".$from_first_name."*!", markdown, $HideKeyboard);

    _info_Zakaz_bota();	
	
	exit('ok');
	
}

function _info_Zakaz_bota() {

	global $bot, $chat_id;
	
	$inLineInfo_ZakazBota = [
		'inline_keyboard' => [
			[
				[
					'text' => 'Ознакомиться',
					'callback_data' => 'ознакомьтесь'
				]
			]
		]
	];
	
	$reply = "Это Бот для подачи заявки на публикацию вашего лота на канале [Покупки на PRIZMarket](https://t.me/prizm_market)\n\nПеред тем как начать писать сообщения внимательно ознакомьтесь с тем, как и в какой последовательности, это необходимо сделать, и с какими условиями. Внимательно ознакомьтесть нажав на кнопку ниже.";

	$bot->sendMessage($chat_id, $reply, markdown, $inLineInfo_ZakazBota, null, true);

}

// функция вывода на печать массива
function PrintArr($mass, $i=0) {
	
	global $flag;
		
	$flag .= "\t\t\t\t";			
		
	foreach($mass as $key[$i] => $value[$i]) {				
		if (is_array($value[$i])) {
				$_this .= $flag . $key[$i] . " : \n";
				$_this .= PrintArr($value[$i], ++$i);
		}else $_this .= $flag . $key[$i] . " : " . $value[$i] . "\n";
	}
	$str = $flag;
	$flag = substr($str, 0, -4);
	return $_this;
	
}

// при возникновении исключения вызывается эта функция
function exception_handler($exception) {

	global $bot, $master;
	
	$bot->sendMessage($master, "Ошибка! ".$exception->getCode()." ".$exception->getMessage());	
  
	exit('ok');  
	
}

function _info_oznakomlenie() {

	global $bot, $chat_id;
	
	$reply = "Для подачи заявки необходимо отправить 2⃣(2)два сообщения:

1⃣(1). Текстовое:
▪️Укажите действие - #куплю или #продам
▪️Напишите название предмета или услуги
▪️Опишите предмет или услугу (описание желательно должно быть полным, для ссылки на подробности)
   - Так же можно указать ссылки на соц.сети и сайты (при указывании ссылки на ваш Инстаграм, объявление попадает на наш [АККАУНТ](https://instagram.com/prizm_market_inst?igshid=1j862dhjasphh)).
▪️Обозначьте стоимость (PRIZM - основная монета, но можно указывать любые виды денежных единиц)
▪️Укажите контакт (@username)  для связи (он будет виден всем на канале)
❗️☝️без @username заявка будет отклонена❗️
  [как создать @username?](https://t.me/podrobno_s_PZP/924) 👈
▪️Напишите Ваш город (или место, регион в котором желаете сотрудничать).


2⃣(2) .Медиа файл:
▪️Загрузите видео, gif,  анимацию или фото Вашего предмета или услуги ( если нет собственного, скачайте из интернета то, что на Ваш взгляд, подходит ).


и ожидайте...


▪️❗️Только 1 лот 1раз в сутки безОплатно❗️и в соответствии формы выше☝️❗️Несоответствие формы повод отклонить заявку.

▪️Более одного раза в сутки или более одного лота в сутки размещение  платное💰

Ежели остались вопросы обращайтесь в техподдержку:
[Support](http://t.me/Prizm_market_supportbot/) 

ВНИМАНИЕ: При отсылке большего количества сообщений, бот автоматически Вас отправит в 'спам'.

❗️ПОПЫТКА ОБМАНУТЬ СЕРВИС, ПРИВОДИТ К ВЕЧНОМУ БАНУ❗️



💥Поддержать проект❗️

Кошелёк:
```PRIZM-UFSC-9S49-ESJX-79N7S```

Публичный ключ:
```11dcf528f8f2ff9dc3c5005cd6fdc3240ea09ceaf96f2dd261255696ccb2842c```

Мы рады быть полезными для Вас !
                
Команда @Prizm_market.";
	

        $reply = str_replace('_', '\_', $reply);

	$bot->sendMessage($chat_id, $reply, markdown);

}



Function _info_otvetnoe() {
	
	global $bot, $chat_id, $message_id;
	
	$reply = "⭕️Ежели Ваше объявление требует повтора, достаточно скопировать ссылку (https://t.me/podrobno_s_PZP/573)  на это обьявление и отправить сюда с просьбой повторить.⭕️

Благодарим вас за ваше участие!

            ⚠️НАПОМНИМ⚠️
/start - перезагрузка бота

Правила размещения поста на канале (https://t.me/podrobno_s_PZP/562) 👈

Как получить ссылку на пост (https://t.me/podrobno_s_PZP/573) 👈

Вопросы можно решать через Support (http://t.me/Prizm_market_supportbot/)



Помощь развития сервиса!!!

Абсолютно по доброй воле❗️

Кошелёк:
PRIZM-UFSC-9S49-ESJX-79N7S
Открытый ключ:
11dcf528f8f2ff9dc3c5005cd6fdc3240ea09ceaf96f2dd261255696ccb2842c";

	
	$reply = str_replace('_', '\_', $reply);

	$bot->sendMessage($chat_id, $reply, markdown, null, $message_id);
	
}




function _deleting_old_records($table, $limit = 0) {
	
	global $mysqli;
	
	$response = false;
	
	$real_date = time();
	
	$required_date = $real_date - $limit;
	
	$query = "DELETE FROM {$table} WHERE date<{$required_date}";
	
	$result = $mysqli->query($query);
	
	if ($result) {
	
		$response = true;
		
	}else throw new Exception("Не смог удалить записи в таблице {$table}");
	
	return $response;

}


function _entry_flag($table) {

	global $mysqli, $from_id;
	
	$query = "SELECT flag FROM {$table} WHERE id_client={$from_id} AND flag=1";
	
	$result = $mysqli->query($query);
	
	if ($result) {
	
		if ($result->num_rows>0) return true;
		
		else return false;
	
	}else throw new Exception("Не смог узнать наличие флажка в таблице {$table}");


}



function _existence($table) {
	
	global $mysqli, $from_id;
	
	$query = "SELECT id_client FROM {$table} WHERE id_client={$from_id}";
	
	$result = $mysqli->query($query);
	
	if ($result) {
	
		if ($result->num_rows>0) return true;
		
		else return false;
	
	}else throw new Exception("Не смог узнать наличие клиента в таблице {$table}");
	
}



function _format_links() {
	
	global $bot, $mysqli, $chat_id, $admin_group, $from_username, $channel_info, $message_id, $from_id;
	
	$existence = _existence('info_users');	
	
	if ($existence) {
		
		if ($id_bota == '475440299') {
		
			$url_info = "https://t.me/check_user_infobot?start=".$from_id;
		
		}elseif ($id_bota == '1052297281') {
		
			$url_info = "https://t.me/Ne_wTest_Bot?start=".$from_id;
			
		}

		$bot->sendMessage($admin_group, $url_info, null, null, null, true);
	
	}else {
	
		if ($from_username == '') {
			   
			$bot->sendMessage($chat_id, "Мы не принимаем заявки от клиентов без @username!\n\n".
				"Возвращайтесь когда поставите себе @username..");
			   
		}else {
			   
			$result = $bot->forwardMessage($channel_info, $chat_id, $message_id);
			   
			if ($result) {
				   
				$result = $bot->sendMessage($channel_info, "@".$from_username);
				   
				if ($result) {
						
					$result = $bot->sendMessage($channel_info, "&".$from_id);
					
					if ($result) {
					
						if ($id_bota == '475440299') {
		
							$url_info = "https://t.me/check_user_infobot?start=".$from_id;
						
						}elseif ($id_bota == '1052297281') {
						
							$url_info = "https://t.me/Ne_wTest_Bot?start=".$from_id;
							
						}

						$bot->sendMessage($admin_group, $url_info, null, null, null, true);
	
					}
						
				}
				   
			}
			   
		}
		
	}
	
}



?>
