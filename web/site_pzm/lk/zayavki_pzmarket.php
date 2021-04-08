<?php

// проверка подключения 
if (mysqli_connect_errno()) {
	throw new Exception('Чёт не выходит подключиться к MySQL');	
	exit('ok');
}

// Обработчик исключений
set_exception_handler('exception_handler');

$ссылка_на_амазон = "https://{$aws_bucket}.s3.{$aws_region}.amazonaws.com/";

$запрос = "SELECT * FROM avtozakaz_pzmarket WHERE username='{$логин}' AND id_client='7' AND status='одобрен' ORDER BY id_zakaz DESC"; 
$результат = $mysqli->query($запрос);
if ($результат)	{
	$количество = $результат->num_rows;
}else throw new Exception('Не смог проверить таблицу `pzm`.. (lk_pzmarket)');	

if($количество > 0) {
	$результМассив = $результат->fetch_all(MYSQLI_ASSOC);
	$номер = 0;
	foreach ($результМассив as $строка) {
		$id_lota = $строка['id_zakaz'];		
		$название = $строка['nazvanie'];	
		$категория = $строка['otdel'];			
		$юникс_дата_публикации = $строка['date'] + 10800;
		$дата_публикации = date("d.m.Y H:i", $юникс_дата_публикации);
		$кнопка_подробнее = "<a href='/site_pzm/podrobnosti/index.php?podrobnosti={$id_lota}'>Подробности</a>";
		$текст_лота = "<h4>{$название}</h4>
			<h4>{$кнопка_подробнее}</h4>";		
		$ссыль_на_фото = $строка['url_tgraph'];	
		
		$ссыль_на_фото = str_replace("http://f0430377.xsph.ru", "https://media.pzmarket.ru", $ссыль_на_фото);

		$лот[$номер] = "<article id='zayavki'><br><hr><br>
				<a href=''><img src='{$ссыль_на_фото}' alt='' title=''/></a>
				{$текст_лота}
				<form action='/site_pzm/lk/zayavki.php' method='post'>					
					<input type='hidden' name='id_lota' value='{$id_lota}'>		

					<h4><input type='submit' class='button' name='repeat_delete' id='repeat'  value='Повторить'></h4>
					
					<h4>Лот {$id_lota}</h4>

					<h4><input type='submit' class='button' name='repeat_delete' id='delete'  value='Удалить'></h4>
				</form>
				
			</article>";		
		$номер++;
	} 
	if (!is_array($лот)) $лот = "<br><h4>{$логин}, у Вас нет опубликованных лотов.</h4>";
}else $лот = "<br><h4>{$логин}, у Вас нет опубликованных лотов.</h4>";

// закрываем подключение 
$mysqli->close();

$ссыль_на_канал_подробности = "https://teleg.link/podrobno_s_PZP";
$ссыль_на_саппорт_бота = "https://teleg.link/Prizm_market_supportbot";

?>		
