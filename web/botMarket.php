<?php 
include_once '../vendor/autoload.php';	
include_once 'a_conect.php';
//exit('ok');
$token = $tokenMARKET;
$tg = new \TelegramBot\Api\BotApi($token);

$id_bota = strstr($token, ':', true);	

// Группа администрирования бота (Админка)
$admin_group = $admin_group_market;

// Канал, где появляются новые лоты
$channel = $channel_market;

if ($_GET['privet']) {
	$tg->sendMessage($obsujdaem_bot_group, $_GET['privet']);
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
	include 'BiblioBota/bot_02_varia.php';
	
	$text = str_replace ("@NaHerokuBot", "", $text);

	// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ФУНКЦИЙ
	include 'BiblioBota/bot_03_func.php';
	
	if ($_GET['kurs']=='pzm'||$_GET['kurs']=='PZM'||$_GET['kurs']=='Prizm'||$_GET['kurs']=='PRIZM'||$_GET['kurs']=='Pzm'||$_GET['kurs']=='пзм'||$_GET['kurs']=='Пзм'||$_GET['kurs']=='ПЗМ'||$_GET['kurs']=='призм'||$_GET['kurs']=='Призм'||$_GET['kurs']=='ПРИЗМ') $_GET['kurs']='prizm';
	
	if ($_GET['kurs']=='prizm') echo _kurs_PZM();
	
	
	$this_admin = _this_admin();
	
	if ($text == "/start"||$text == "s"||$text == "S"||$text == "с"||$text == "С"||$text == "c"||$text == "C"||$text == "Старт"||$text == "старт") {
		if ($chat_type=='private') {
			//_start_PZMgarant_bota($this_admin);  //БЕЗОПАСНЫЕ СДЕЛКИ
			
			_start_PZMarket_bota($this_admin);  // PZMarket
		}	
	}
	
	// ПОДКЛЮЧЕНИЕ ОСНОВНОГО МОДУЛЯ
	include_once 'BiblioBota/bot_01_head.php';		
}

// закрываем подключение 
$mysqli->close();		

exit('ok'); //Обязательно возвращаем "ok", чтобы телеграмм не подумал, что запрос не дошёл
?>
