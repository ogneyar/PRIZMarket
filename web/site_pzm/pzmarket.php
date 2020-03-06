<?php	
// Подключаем библиотеку с классом Bot
include_once '../myBotApi/Bot.php';
//exit('ok');
$token = $tokenMARKET;
// Создаем объект бота
//$bot = new \myBotApi\Bot($token);
$id_bota = strstr($token, ':', true);	
// ПОДКЛЮЧЕНИЕ ВСЕХ ОСНОВНЫХ ПЕРЕМЕННЫХ
//include '../myBotApi/Variables.php';

$mysqli = new mysqli($host, $username, $password, $dbname);

// проверка подключения 
if (mysqli_connect_errno()) {
	throw new Exception('Чёт не выходит подключиться к MySQL');	
	exit('ok');
}

// Обработчик исключений
set_exception_handler('exception_handler');

//echo '1';

$ссылка_на_амазон = "https://{$aws_bucket}.s3.{$aws_region}.amazonaws.com/";

$запрос = "SELECT * FROM pzmarkt"; 
$результат = $mysqli->query($запрос);
if ($результат)	{
	$i = $результат->num_rows;
}else throw new Exception('Не смог проверить таблицу `pzmarkt`.. (работа сайта)');	

if($i>0) $arrS = $результат->fetch_all();		
else throw new Exception('Таблица пуста.. (работа сайта)');
		
$a=0;
$дата_публикации = [];
$текст_лота = [];
$ссыль_на_фото = [];
$лот = [];
while ($a<5){
	
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
		$юникс_дата_публикации = $arrS[$i][12];
		$дата_публикации[$a] = date("d.m.Y H:i", $юникс_дата_публикации);
		
		$ссыль_на_телегу = substr(strrchr($юзера_имя, "@"), 1);
		$ссыль_на_телегу = "https://teleg.link/{$ссыль_на_телегу}";		

		$текст_лота[$a] = "<p>{$куплю_продам}</p><br/><p>{$otdel}</p><p><a href={$url}>{$название}</a></p>".
			"<p>{$валюта}</p><p>{$хештеги}</p><p><a href={$ссыль_на_телегу}>{$юзера_имя}</a></p><br/>";			
			
		$ссыль_на_фото[$a] = $ссылка_на_амазон . $id_lota . ".jpg";		
		
		$лот[$a] = "<article>
				<h3>
				<a href='' title=''><img src='{$ссыль_на_фото[$a]}' alt='' title=''/></a>{$текст_лота[$a]}		
				<p><a href='' title=''>Подробности</a><span>{$дата_публикации[$a]}</span></p>
				</h3>
			</article>";
		
	}
	
	$a++;	
}	

if ($_GET['podrobnosti']) {
	echo "ДААААААААААААААААААААА";
}

// закрываем подключение 
$mysqli->close();		


// при возникновении исключения вызывается эта функция
function exception_handler($exception) {
	
	echo "Ошибка! ".$exception->getCode()." ".$exception->getMessage();	  
	
	exit('ok');  	
	
}

$ссыль_на_канал_подробности = "https://teleg.link/podrobno_s_PZP";

$ссыль_на_саппорт_бота = "https://teleg.link/Prizm_market_supportbot";


?>		
