<?
include_once '../vendor/autoload.php';
// Подключаем библиотеку с классом Bot
include_once 'myBotApi/Bot.php';
// бот для ICQnew
include_once 'myBotApi/ICQnew.php';
// бот для ВКонтакте
include_once 'myBotApi/VK.php';
// Подключаем библиотеку с классом Tgraph
include_once 'myBotApi/Tgraph.php';
// Подключаем библиотеку с классом ImgBB
include_once 'myBotApi/ImgBB.php';
// Подключаем библиотеку с глобальными переменными
include_once 'a_conect.php';
//exit('ok');

$token = $tokenAvtoZakaz;

// Создаем объект бота
$bot = new Bot($token);
$id_bota = strstr($token, ':', true);	

// Создаем объект ICQnew бота
$bot_icq = new ICQnew($ICQtoken);
$id_icq_bota = substr(strstr($ICQtoken, ':'), 1);	

// Создаем объект ICQnew бота
$vk2 = new VK($vk_token2);

$Tgraph = new Tgraph($tokenTGraph);
$imgBB = new ImgBB($api_key);

$table_market = 'avtozakaz_pzmarket';
$table_users = 'avtozakaz_users';
$таблица_ожидание = 'avtozakaz_ojidanie';
$таблица_медиагруппа = 'avtozakaz_mediagroup';

// Группа администрирования бота (Админка)
$admin_group = $admin_group_AvtoZakaz;

// Подключение к Амазон
$credentials = new Aws\Credentials\Credentials($aws_key_id, $aws_secret_key);

$s3 = new Aws\S3\S3Client([
	'credentials' => $credentials, 
	'version'  => 'latest',
	'region'   => $aws_region
]);

// Подключение БД
$mysqli = new mysqli($host, $username, $password, $dbname);

// проверка подключения 
if (mysqli_connect_errno()) {
	$bot->sendMessage($master, 'Чёт не выходит подключиться к MySQL');	
	exit('ok');
}else { 	

	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ФУНКЦИЙ
	include 'BiblaAvtoZakaz/Functions.php';	
	
	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ПЕРЕМЕННЫХ
	include 'myBotApi/Variables.php';
	
	//$bot->sendMessage($master, $bot->PrintArray($data)); 
		
	// Обработчик исключений
	set_exception_handler('exception_handler');
	
	$bot->_проверка_БАНа('info_users', $chat_id);	
	
	if ($chat_type == 'private' && !$from_is_bot) $bot->add_to_database($table_users);
	
	if (!$from_username && $chat_type == 'private') {
 
		$bot->sendMessage($chat_id, "Мы не работаем с клиентами без @username!\n\n".
			"Возвращайтесь когда поставите себе @username..\n\n\n[Как установить юзернейм?](https://t.me/podrobno_s_PZP/924)", "markdown");
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
	
}

// закрываем подключение 
$mysqli->close();		


exit('ok'); //Обязательно возвращаем "ok", чтобы телеграмм не подумал, что запрос не дошёл
?>
