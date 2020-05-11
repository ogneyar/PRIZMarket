<?
include_once '../../a_conect.php';
$mysqli = new mysqli($host, $username, $password, $dbname);

/*
** 	Функции для работы сайта
** 	------------------------
**
** _последняя_публикация_на_сайте
**
**
**
**
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


?>