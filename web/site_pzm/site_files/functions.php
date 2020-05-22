<?
include_once '../../a_mysqli.php';

/*
** 	Функции для работы сайта
** 	------------------------
**
** exception_handler
**
** _последняя_публикация_на_сайте
** _подтверждён_ли_клиент
** _сравни_токен_и_логин
** _сравни_лот_и_логин
** _удали_лот
** _установка_времени
** _ожидание_публикации
** _выбор_времени_публикации
** _обнулить_секунды
**
** _вывод_лотов_по_категории
**
**
*/

// при возникновении исключения вызывается эта функция
function exception_handler($exception) {
	global $mysqli;
	echo "Ошибка! ".$exception->getCode()." ".$exception->getMessage();	  
	$mysqli->close();		
	exit;  	
}

// Проверка давно ли была последняя публикация лота у данного клиента
function _последняя_публикация_на_сайте($логин) {	
	global $mysqli;	
	
	if ($логин == 'Огнеяр' || $логин == 'Otrad_ya' || $логин == 'Логин') return true;
	
    $ответ = false;	
	$query = "SELECT date FROM `avtozakaz_pzmarket` WHERE id_client='7' AND username='{$логин}'";	
	$result = $mysqli->query($query);	
	if ($result) {	
		if ($result->num_rows>0) {        
			$результат = $result->fetch_all(MYSQLI_ASSOC);			
			$время = time()-80000; // примерно 22 часа, а точнее 22,22222222222			
			$давно = true; // если публикация была давно			
			foreach ($результат as $строка) {				
				if ($строка['date']>$время) $давно = false;				
			}		
            if ($давно) $ответ = true;
		}else $ответ = true;	
	}
	//else throw new Exception("Не смог узнать наличие лота у клиента {$логин} (_последняя_публикация_на_сайте)");	
    return $ответ;
}

function _подтверждён_ли_клиент($логин) {
	global $mysqli;	
	
	$ответ = false;
	$запрос = "SELECT vremya FROM `site_users` WHERE login='{$логин}' AND podtverjdenie='true'"; 
	$результат = $mysqli->query($запрос);
	if ($результат)	{
		$количество = $результат->num_rows;	
		if($количество > 0) {
			$ответ = true;			
		}
	}else {
		   echo 'Не смог проверить наличие клиента в базе...';	
		   exit;
	} 
	return $ответ;
}

function _сравни_токен_и_логин($логин, $токен) {
	global $mysqli;	
	
	$ответ = false;
	$запрос = "SELECT vremya FROM `site_users` WHERE login='{$логин}' AND token='{$токен}'"; 
	$результат = $mysqli->query($запрос);
	if ($результат)	{
		$количество = $результат->num_rows;	
		if($количество > 0) {
			$ответ = true;			
		}
	}else {
		   echo 'Не смог сопоставить логин клиента и его токен...';	
		   exit;
	} 
	return $ответ;
}

function _сравни_лот_и_логин($логин, $лот) {
	global $mysqli;	
	
	$ответ = false;
	$запрос = "SELECT date FROM `avtozakaz_pzmarket` WHERE username='{$логин}' AND id_zakaz='{$лот}'"; 
	$результат = $mysqli->query($запрос);
	if ($результат)	{
		$количество = $результат->num_rows;	
		if($количество > 0) {
			$ответ = true;			
		}
	}else {
		   echo 'Не смог сопоставить номер лота и логин клиента...';	
		   exit;
	} 
	return $ответ;
}

function _удали_лот($лот) {
	global $mysqli;	
	
	$ответ = false;
	$запрос = "DELETE FROM `avtozakaz_pzmarket` WHERE id_zakaz='{$лот}'"; 
	$результат = $mysqli->query($запрос);
	if ($результат)	{
		
		$ответ = true;			
		
	}else {
		   echo "Не смог удалить лот {$лот}...";	
		   exit;
	} 
	return $ответ;
}

// функция установки времени публикации
function _установка_времени($номер_лота) {		
	global $mysqli;	
	
	$время = time();	
	$query ="UPDATE `avtozakaz_pzmarket` SET date='{$время}' WHERE id_zakaz={$номер_лота}";		
	$result = $mysqli->query($query);			
	if (!$result) {
		echo "Не смог обновить запись в таблице avtozakaz_pzmarket (_установка_времени)";	
		exit;
	}
	return true;
}

// функция постановки лота в ожидание публикации
function _ожидание_публикации($номер_лота) {		
	global $tokenAvtoZakaz, $mysqli;		
	
	$ответ = false;	
	
	$id_bota = strstr($tokenAvtoZakaz, ':', true);		
	
	$запрос ="SELECT soderjimoe FROM `variables` WHERE id_bota={$id_bota} AND nazvanie='номер_лота' AND soderjimoe='{$номер_лота}'";				
	$результат = $mysqli->query($запрос);
	if ($результат) {
		if ($результат->num_rows > 0) {			
			echo "<label>Такой заказ в ожидании на публикацию уже есть!</label>";	
			exit;
		}else {
			$время_публикации = _выбор_времени_публикации();
			$запрос ="INSERT INTO `variables` (
				`id_bota`, `nazvanie`, `soderjimoe`, `opisanie`, `vremya`
			) VALUES (
				'{$id_bota}', 'номер_лота', '{$номер_лота}', '', '{$время_публикации}'
			)";						
			$результат = $mysqli->query($запрос);								
			if ($результат) {
				$ответ = $время_публикации;
			}else echo "<label>Не смог добавить запись в таблицу (_ожидание_публикации)</label>";				
		}			
	}else echo "<label>Не смог узнать наличие записи в таблице (_ожидание_публикации)</label>";	

	return $ответ;	
}

// функция проверки наличия лотов в ожидании, если есть, то показывает время последнего в очереди
function _выбор_времени_публикации() {
	global $tokenAvtoZakaz, $mysqli;
	
	$id_bota = strstr($tokenAvtoZakaz, ':', true);
	
	$ответ = false;
	
	$UNIXtime = time();
	$UNIXtime_Moscow = $UNIXtime + 10800;	
	$время = _обнулить_секунды($UNIXtime_Moscow);
	
	$запрос ="SELECT vremya FROM `variables` WHERE id_bota={$id_bota} AND nazvanie='номер_лота'";			
	$результат = $mysqli->query($запрос);
	if ($результат) {	
		$количество = $результат->num_rows;
		if ($количество > 0) {
			$результМассив = $результат->fetch_all(MYSQLI_ASSOC);			
			$последняя_в_очереди = 0;
			foreach($результМассив as $строка) {
				if ($строка['vremya'] > $последняя_в_очереди) $последняя_в_очереди = $строка['vremya'];
			}			
			if ($последняя_в_очереди > $время) $ответ = $последняя_в_очереди + 1200; // + 20 мин
		}		
		if (!$ответ) {			
			$минута = date("i", $время);
			if ($минута > 48) {
				$смещение = 70 - $минута;
			}elseif ($минута > 28) {
				$смещение = 50 - $минута;
			}elseif ($минута > 8) {
				$смещение = 30 - $минута;
			}else $смещение = 10 - $минута;
			$ответ = $время + $смещение * 60;		
		}		
		$счётчик = false;
		while ($счётчик == false) {
			$бронь = _нет_ли_брони($ответ);
			if ($бронь == "свободно") {
				$счётчик = true;
			}else {
				$ответ = $ответ + 1200;
			}				
		}		
	}else echo "<label>Не смог сделать запрос к таблице (_выбор_времени_публикации)</label>";
	return $ответ;
}


// функция удаляет секунды реального времени в юникс времени
function _обнулить_секунды($юникс_время) {	
	$ответ = false;
	$год = date("Y", $юникс_время);
	$месяц = date("m", $юникс_время);
	$день = date("d", $юникс_время);			
	$час = date("H", $юникс_время);
	$минута = date("i", $юникс_время);			
	$ответ = mktime($час, $минута, 0, $месяц, $день, $год);
	return $ответ;
}

// функция проверяет есть ли бронь публикации на заданное время 
function _нет_ли_брони($время) {		// если нет брОни, вернёт "свободно"
	global $tokenAvtoZakaz, $mysqli;	
	$id_bota = strstr($tokenAvtoZakaz, ':', true);	
	$ответ = false;
	$запрос ="SELECT * FROM `variables` WHERE id_bota={$id_bota} AND nazvanie='бронь' AND vremya='{$время}'";
	$результат = $mysqli->query($запрос);
	if ($результат) {			
		if ($результат->num_rows == 0) $ответ = "свободно";
	}else echo "<label>Не смог узнать наличие записи в таблице (_нет_ли_брони)</label>";		
	return $ответ;	
}


// Вывод лотов по категорияи
function _вывод_лотов_по_категории($категория) {	
	global $mysqli;	
	
	if ($логин == 'Огнеяр' || $логин == 'Otrad_ya' || $логин == 'Логин') return true;
	
    $ответ = false;	
	$query = "SELECT date FROM `avtozakaz_pzmarket` WHERE id_client='7' AND username='{$логин}'";	
	$result = $mysqli->query($query);	
	if ($result) {	
		if ($result->num_rows>0) {        
			$результат = $result->fetch_all(MYSQLI_ASSOC);			
			$время = time()-80000; // примерно 22 часа, а точнее 22,22222222222			
			$давно = true; // если публикация была давно			
			foreach ($результат as $строка) {				
				if ($строка['date']>$время) $давно = false;				
			}		
            if ($давно) $ответ = true;
		}else $ответ = true;	
	}
	//else throw new Exception("Не смог узнать наличие лота у клиента {$логин} (_последняя_публикация_на_сайте)");	
    return $ответ;
}

?>
