<?php	
// Подключаем библиотеку с классом Bot
//include_once 'myBotApi/Bot.php';
//exit('ok');
$token = $tokenMARKET;
// Создаем объект бота
//$bot = new \myBotApi\Bot($token);

$tg = new \TelegramBot\Api\BotApi($token);

$id_bota = strstr($token, ':', true);	
// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ПЕРЕМЕННЫХ
//include 'myBotApi/Variables.php';

$admin_group = $admin_group_market;

//$bot->sendMessage($admin_group, "йээээээээээээээ");

$tg->sendMessage($admin_group, "йээээээээээээээ");

/*
$mysqli = new mysqli($host, $username, $password, $dbname);

// проверка подключения 
if (mysqli_connect_errno()) {
	throw new Exception('Чёт не выходит подключиться к MySQL');	
	exit('ok');
}

// Обработчик исключений
set_exception_handler('exception_handler');

$ссылка_на_амазон = "https://{$aws_bucket}.s3.{$aws_region}.amazonaws.com/";

$показ_одного_лота = '';

$запрос = "SELECT * FROM pzmarkt"; 
$результат = $mysqli->query($запрос);
if ($результат)	{
	$i = $результат->num_rows;
}else throw new Exception('Не смог проверить таблицу `pzm`.. (работа сайта)');	

if($i>0) $arrS = $результат->fetch_all();		
else throw new Exception('Таблица пуста.. (работа сайта)');
		

// закрываем подключение 
$mysqli->close();

// при возникновении исключения вызывается эта функция
function exception_handler($exception) {
	global $mysqli;
	echo "Ошибка! ".$exception->getCode()." ".$exception->getMessage();	  
	$mysqli->close();		
	exit('ok');  	
}
*/
?>		
