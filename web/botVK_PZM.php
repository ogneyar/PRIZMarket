<?
// Подключаем библиотеку с классом Bot
//include_once 'myBotApi/Bot.php';

// бот ВК
//include_once 'myBotApi/VK.php';

include_once 'a_conect.php';
//exit('ok');

// Создаем объект бота
//$bot = new Bot($token);
//$id_bota = strstr($token, ':', true);	

// Создаем объект VK бота
//$bot_vk = new VK($vk_token);

$айди_вк_группы = "190150616";

//$data_vk = $bot_vk->init('php://input');

$data_vk = json_decode(file_get_contents('php://input'));

if ($data_vk->type == "confirmation") echo $vk_api_response;

elseif ($data_vk->object->body == "Прива") {

   //mesSend();

   $массив = [
      "access_token" => $vk_token, 
      "peer_id" => $data_vk->object->user_id, 
      "message" => "Ну да, здравствуй)", 
      "v" => $vk_api_version
   ];

  file_get_contents("https://api.vk.com/method/". "messages.send?". http_build_query($массив));


}elseif ($data_vk->type == "message_new") {

   include_once "BiblaVK_PZM/Message.php"; 

} 



//($data_vk->object->body == "Прива") mesSend();







//$table_market = 'avtozakaz_pzmarket';

// Подключение БД
//$mysqli = new mysqli($host, $username, $password, $dbname);




	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ФУНКЦИЙ
	//include 'BiblaVK_PZM/Functions.php';	



	
	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ПЕРЕМЕННЫХ
	//include 'myBotApi/Variables.php';
	
	//$bot->sendMessage($master, $bot->PrintArray($data)); 
		
	// Обработчик исключений
	//set_exception_handler('exception_handler');
	

/*

	$bot->_проверка_БАНа('info_users', $chat_id);	
	
	if ($chat_type == 'private' && !$from_is_bot) $bot->add_to_database($table_users);
	
	if (!$from_username && $chat_type == 'private') {
 
		$bot->sendMessage($chat_id, "Мы не работаем с клиентами без @username!\n\n".
			"Возвращайтесь когда поставите себе @username..\n\n\n[Как установить юзернейм?](https://t.me/podrobno_s_PZP/924)", markdown);
		exit('ok');		
			
	}
	
	// Если пришла ссылка типа t.me//..?start=123456789
	if (strpos($text, "/start ")!==false) $text = str_replace ("/start ", "", $text);
	
	if ($text == "/start"||$text == "s"||$text == "S"||$text == "с"||$text == "С"||$text == "c"||$text == "C"||$text == "Старт"||$text == "старт") {
		if ($chat_type=='private') {
			_старт_АвтоЗаказБота();  			
		}	
	}
	
	if ($chat_type == 'private' && $reply_markup['inline_keyboard'][0][0]['text'] == 'Подробнее') {
		include_once 'BiblaAvtoZakaz/Data_transfer.php';
		exit('ok');
	}

	if ($chat_type == 'private' || $chat_id == $admin_group || $chat_id == $channel_info) {
		
		if ($data['callback_query']) {
		
			include_once 'BiblaAvtoZakaz/Callback_query.php';
			
		
		}elseif ($data['channel_post']) {
			
			include_once 'BiblaAvtoZakaz/Channel_post.php';
			
		}elseif ($data['edited_message']) {
		
			//include_once 'BiblaAvtoZakaz/Edit_message.php';		
		
		// если пришло сообщение MESSAGE подключается необходимый файл
		}elseif ($data['message']) {
			
			//-----------------------------
			// это команды бота для мастера
			if ($text){
				$number = stripos($text, '%');
				if ($number!==false&&$number == '0') {
					if ($chat_id==$master) {
						$text = substr($text, 1);
						include_once 'BiblaAvtoZakaz/Commands.php';
						exit('ok');
					}
				}
			}
			//-----------------------------
					
			include_once 'BiblaAvtoZakaz/Message.php';		
			
		}

	}
	
	if ($inline_query) {
	
		include_once 'BiblaAvtoZakaz/Inline_query.php';
	
	}
	
*/

// закрываем подключение 
//$mysqli->close();		


//exit('ok'); //Обязательно возвращаем "ok", чтобы телеграмм не подумал, что запрос не дошёл
?>
