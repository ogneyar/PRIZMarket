<?php	
// Подключаем библиотеку с классом Bot
include_once '../myBotApi/Bot.php';
// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ПЕРЕМЕННЫХ
include_once '../myBotApi/Variables.php';
//exit('ok');	
// Группа администрирования бота (Админка)
$admin_group = $admin_group_market;

$token = $tokenMARKET;
// Создаем объект бота
$bot = new \Bot($token);

$id_bota = strstr($token, ':', true);	

$mysqli = new mysqli($host, $username, $password, $dbname);

// проверка подключения 
if (mysqli_connect_errno()) {
	$bot->sendMessage($master, 'Чёт не выходит подключиться к MySQL');	
	exit('ok');
}

// Обработчик исключений
//set_exception_handler('exception_handler');

//echo '1';

$ссылка_на_амазон = "https://{$aws_bucket}.s3.{$aws_region}.amazonaws.com/";
	
$запрос = "SELECT * FROM pzmarkt"; 
$результат = $mysqli->query($запрос);
if ($результат)	{
	$i = $результат->num_rows;
}else {
	$bot->sendMessage($master, 'Не смог проверить таблицу `pzmarkt`.. (работа сайта)');
	exit('ok');	
}

if($i>0) $arrS = $результат->fetch_all();		
else {
	$bot->sendMessage($master, 'Таблица пуста.. (работа сайта)');
	exit('ok');	
}
		
$a=0;
$текст_лота = [];
$ссыль_на_фото = [];
while ($a<3){
	
	if($i>0){
	
		$i--;		
		
		$format=$arrS[$i][2];
		while (($format=='video')&&($i>0)) {
			$i--;
			$format=$arrS[$i][2];
		}	
		
		$id_lota=$arrS[$i][0];	
		$otdel=$arrS[$i][1];		
		//$file_id=$arrS[$i][3];
		$url=$arrS[$i][4];
		$url = str_replace("t.me", "teleg.link", $url);
		$куплю_продам=$arrS[$i][5];
		$название=$arrS[$i][6];
		$валюта=$arrS[$i][7];
		$хештеги=$arrS[$i][8];
		$юзера_имя=$arrS[$i][9];
		//$doverie=$arrS[$i][10];
		//$podrobno_url=$arrS[$i][11];		
		
		$ссыль_на_телегу = substr(strrchr($юзера_имя, "@"), 1);
		$ссыль_на_телегу = "https://teleg.link/{$ссыль_на_телегу}";		

		$текст_лота[$a] = "<p>{$куплю_продам}</p><p>{$otdel}</p><p><a href={$url}>{$название}</a></p>".
			"<p>{$валюта}</p><p>{$хештеги}</p><p><a href={$ссыль_на_телегу}>{$юзера_имя}</a></p>";			
			
		$ссыль_на_фото[$a] = $ссылка_на_амазон . $id_lota . ".jpg";
		
	}
	
	$a++;	
}	

// закрываем подключение 
$mysqli->close();		

/*
// при возникновении исключения вызывается эта функция
function exception_handler($exception) {
	global $bot, $master;	
	$bot->sendMessage($master, "Ошибка! ".$exception->getCode()." ".$exception->getMessage());	  
	exit('ok');  	
}
*/


?>		