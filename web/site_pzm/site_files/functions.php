<?
include_once '../../a_mysqli.php';
//$mysqli = new mysqli($host, $username, $password, $dbname);

/*
** 	Функции для работы сайта
** 	------------------------
**
** _последняя_публикация_на_сайте
** _подтверждён_ли_клиент
** _сравни_токен_и_логин
** _сравни_лот_и_логин
** _удали_лот
**
**
*/

// Проверка давно ли была последняя публикация лота у данного клиента
function _последняя_публикация_на_сайте($логин) {	
	global $mysqli;	
	
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
?>
