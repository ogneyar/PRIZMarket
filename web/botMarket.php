<?php 
include_once '../vendor/autoload.php';	
include_once 'a_conect.php';
exit('ok');

$token = $tokenMARKET;
$tg = new \TelegramBot\Api\BotApi($token);

$id_bota = strstr($token, ':', true);	

// Группа администрирования бота (Админка)
$admin_group = $admin_group_market;

// Канал, где появляются новые лоты
$channel = $channel_market;

$Макс_гарант = '630509100';
$Макса_группа = '-1001387747179';

if ($_GET['privet']) {
	$tg->sendMessage($admin_group, $_GET['privet']);
	echo "Сообщение {$_GET['privet']} отправленно в группу!";
}

// Подключение к Амазон
$credentials = new Aws\Credentials\Credentials($aws_key_id, $aws_secret_key);
	
$s3 = new Aws\S3\S3Client([
	'credentials' => $credentials, 
    'version'  => 'latest',
    'region'   => $aws_region
]);

$mysqli = new mysqli($host, $username, $password, $dbname);

// проверка подключения 
if (mysqli_connect_errno()) {
	$tg->sendMessage($master, 'Чёт не выходит подключиться к MySQL');	
	exit('ok');
}else { 	
	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ПЕРЕМЕННЫХ
	include 'BiblaMarket/bot_02_varia.php';
	
	$text = str_replace ("@NaHerokuBot", "", $text);

	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ФУНКЦИЙ
	include 'BiblaMarket/bot_03_func.php';
	
	_проверка_БАНа('info_users', $chat_id);
	
	if ($_GET['kurs']=='pzm'||$_GET['kurs']=='PZM'||$_GET['kurs']=='Prizm'||$_GET['kurs']=='PRIZM'||$_GET['kurs']=='Pzm'||$_GET['kurs']=='пзм'||$_GET['kurs']=='Пзм'||$_GET['kurs']=='ПЗМ'||$_GET['kurs']=='призм'||$_GET['kurs']=='Призм'||$_GET['kurs']=='ПРИЗМ') $_GET['kurs']='prizm';
	
	if ($_GET['kurs']=='prizm') echo _kurs_PZM();
	
	
	$this_admin = _this_admin();
/*
if ($chat_id!=$master) {
	$tg->sendMessage($chat_id, "Профилактические работы! Ожидайте, работа бота скоро возобновится..");
	exit('ok');
}
*/

        
	// Если пришла ссылка типа t.me//..?start=123456789
	if (strpos($text, "/start ")!==false) $text = str_replace ("/start ", "", $text);
	

	if ($text == "/start"||$text == "s"||$text == "S"||$text == "с"||$text == "С"||$text == "c"||$text == "C"||$text == "Старт"||$text == "старт") {
		if ($chat_type=='private') {
			//_start_PZMgarant_bota($this_admin);  //БЕЗОПАСНЫЕ СДЕЛКИ
			
			_start_PZMarket_bota($this_admin);  // PZMarket
		}	
	}
	
		// это команды бота для мастера
		if ($text){
			$number = stripos($text, '%');
			if ($number!==false&&$number == '0') {
				if ($chat_id==$master) {
					$text = substr($text, 1);
					include_once 'BiblaMarket/Commands.php';
					exit('ok');
				}
			}
		}
		//-----------------------------
	
	// ПОДКЛЮЧЕНИЕ ОСНОВНОГО МОДУЛЯ
	include_once 'BiblaMarket/bot_01_head.php';		
}

// закрываем подключение 
$mysqli->close();		

exit('ok'); //Обязательно возвращаем "ok", чтобы телеграмм не подумал, что запрос не дошёл
?>
