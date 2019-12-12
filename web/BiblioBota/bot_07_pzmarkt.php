<?php

if ($arr['message']['photo']||$arr['message']['video']){
		
	$id = substr(strrchr($urlPodrobno, '/'), 1);
	
	$est_li_v_base=false;
	
	$query = "SELECT id FROM ".$table5;
	if ($result = $mysqli->query($query)) {		
		$kol=$result->num_rows;
		if($kol>0){
			$arrStrok = $result->fetch_all();
			foreach($arrStrok as $stroka) if ($id==$stroka[0]) $est_li_v_base=true;					
		}				
	}else throw new Exception("Не получилось получить запрос от ".$table5);
	
	if ($est_li_v_base==true) {		
	
		$query = "DELETE FROM ".$table5." WHERE id=". $id;				
		if ($result = $mysqli->query($query)) {					
			$tg->sendMessage($chat_id, "Дублирующий лот удалён!");								
		}else $tg->sendMessage($chat_id, "Не получается удалить дублирующий лот!");	
		
	}	


	$flag=0;
	$doverie=0;

	$caption1 = strstr($caption, 10, true);
	$kol=strlen($caption1)+2;			
	$caption = substr($caption, $kol);
	//$caption1 = substr($caption1, 1);

	$caption2 = strstr($caption, 10, true);
	$kol=strlen($caption2)+1;			
	$caption = substr($caption, $kol);
	//$caption2 = substr($caption2, 3);

	$caption3 = strstr($caption, 10, true);
	$kol=strlen($caption3)+1;			
	$caption = substr($caption, $kol);
	//$caption3 = substr($caption3, 6);

	$caption4 = strstr($caption, 10, true);
	$kol=strlen($caption4)+1;			
	$caption = substr($caption, $kol);
	//$caption4 = substr($caption4, 7);

	$caption5 = strstr($caption, 10, true);
	if ($caption5==false) $caption5=$caption;
	else{
		$doverie=1;
	}	
	
	$query = "INSERT INTO ".$table5." VALUES ('{$id}', '0', '{$format}', '{$file_id}', '{$urlCaption}'".
		", '{$caption1}', '{$caption2}', '{$caption3}', '{$caption4}', '{$caption5}', '{$doverie}'".
		", '{$urlPodrobno}', '{$flag}')";	
	
	if ($result = $mysqli->query($query)) {		
		$reply="Данные добавленны в таблицу ".$table5."\n\nВ ответном сообщении пришлите номер отдела, в котором".
			" будет размещён лот:\n{$spisok}\n\n{$id} o.";
		$tg->sendMessage($chat_id, $reply, null, false, null, $forceRep); 
		exit('ok');
	}else{ 
		$reply="Не получилось добавить данные в таблицу ".$table5;
		$tg->sendMessage($chat_id, $reply); 
		throw new Exception($reply);
	}

}else $tg->sendMessage($chat_id, "Неее, мне надо с фоткой или с видео..\n..гифка не катит)"); 







?>