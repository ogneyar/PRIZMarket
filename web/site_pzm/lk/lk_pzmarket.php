<?php	
include_once '../../a_conect.php';

$mysqli = new mysqli($host, $username, $password, $dbname);

// проверка подключения 
if (mysqli_connect_errno()) {
	throw new Exception('Чёт не выходит подключиться к MySQL');	
	exit('ok');
}

// Обработчик исключений
set_exception_handler('exception_handler');

$ссылка_на_амазон = "https://{$aws_bucket}.s3.{$aws_region}.amazonaws.com/";

$запрос = "SELECT * FROM avtozakaz_pzmarket WHERE username='{$_COOKIE['login']}' AND id_client='7' AND status='одобрен'"; 
$результат = $mysqli->query($запрос);
if ($результат)	{
	$количество = $результат->num_rows;
}else throw new Exception('Не смог проверить таблицу `pzm`.. (lk_pzmarket)');	

if($количество > 0) {
	$результМассив = $результат->fetch_all(MYSQLI_ASSOC);
	$номер = 0;
	$лот = [];
	foreach ($результМассив as $строка) {
		$id_lota = $строка['id_zakaz'];			
		$название = $строка['nazvanie'];
		//$куплю_или_продам = $строка['kuplu_prodam'];						
		//$валюта = $строка['valuta'];				
		//$хештеги_города = $строка['gorod'];			
		$категория = $строка['otdel'];			
		$юникс_дата_публикации = $строка['date'] + 10800;
		$дата_публикации = date("d.m.Y H:i", $юникс_дата_публикации);
		$кнопка_подробнее = "<a href='/site_pzm/podrobnosti/index.php?podrobnosti={$id_lota}'>Подробности</a>";
		$текст_лота = "<h4>{$категория}</h4>
			<h4>{$название}</h4>
			<h4>{$кнопка_подробнее}</h4>
			<h4>{$дата_публикации}</h4>";
		$ссыль_на_фото = $ссылка_на_амазон . $id_lota . ".jpg";
		$лот[$номер] = "<article id='zayavki'>
				<a href=''><img src='{$ссыль_на_фото}' alt='' title=''/></a>
				{$текст_лота}
			</article>";		
		$номер++;
	}
}else $лот[0] = "<article id='zayavki'><h4>{$_COOKIE['login']}, у Вас нет опубликованных лотов.</h4></article>";

// закрываем подключение 
$mysqli->close();

// при возникновении исключения вызывается эта функция
function exception_handler($exception) {
	global $mysqli;
	echo "Ошибка! ".$exception->getCode()." ".$exception->getMessage();	  
	$mysqli->close();		
	exit('ok');  	
}

$ссыль_на_канал_подробности = "https://teleg.link/podrobno_s_PZP";
$ссыль_на_саппорт_бота = "https://teleg.link/Prizm_market_supportbot";

?>		
