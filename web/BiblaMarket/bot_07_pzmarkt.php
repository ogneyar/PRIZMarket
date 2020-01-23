<?php
	
$urlPodrobno=$arrayChannelOrMessage['reply_markup']['inline_keyboard'][0][0]['url'];
		
if ($arrayChannelOrMessage['photo']){
	if ($arrayChannelOrMessage['photo'][2]){
		$file_id=$arrayChannelOrMessage['photo'][2]['file_id'];	
	}elseif ($arrayChannelOrMessage['photo'][1]){
		$file_id=$arrayChannelOrMessage['photo'][1]['file_id'];	
	}else $file_id=$arrayChannelOrMessage['photo'][0]['file_id'];	
	$format="photo";
}elseif ($arrayChannelOrMessage['video']){
	$file_id=$arrayChannelOrMessage['video']['file_id'];	
	$format="video";
}
		
$caption=$arrayChannelOrMessage['caption'];
if($arrayChannelOrMessage['caption_entities']){
	foreach ($arrayChannelOrMessage['caption_entities'] as $value) {
		if ($value['type']=='text_link') $urlCaption=$value['url'];		
	}
}	
	
	
if ($arrayChannelOrMessage['photo']||$arrayChannelOrMessage['video']){
		
	$id = substr(strrchr($urlPodrobno, '/'), 1);	
	
	if ($format=='photo'){
		$key = $id . ".jpg";
	}else if ($format=='video'){
		$key = $id . ".mp4";
	}
	
// отправка файла на Амазон		
	$fileObject = $tg->getFile($file_id);		
	$file_url = $tg->getFileUrl();	
	$url = $file_url . "/" . $fileObject->getFilePath();
	
	$file = file_get_contents($url);
  
	$upload = $s3->putObject([
		'Bucket' => $aws_bucket,
		'Key'    => $key, 
		'Body'   => $file,	
		'ACL'    => 'public-read'
	]);			
// ---------------------------				
/*	
	if($upload){
		$reply = "Файл лота отправлен на Amazon!";
		if ( ($chat_type=='private'||$callbackChat_type=='private') ){				
			$tg->sendMessage($chat_id, $reply); 
		}else $tg->sendMessage($admin_group, $reply); 
	}else throw new Exception("Не смог отправить файл на Амазон");		
*/
if(!$upload) throw new Exception("Не смог отправить файл на Амазон");	
	
	$time = time();
	$doverie = 0;

	$caption1 = strstr($caption, 10, true);
	$kol=strlen($caption1)+1;			
	$caption = substr($caption, $kol);	
	
	if ($caption1=='') exit('ok');
	
	$ishnee = strstr($caption, 10, true);	
	$kol=strlen($ishnee)+1;	
	$caption = substr($caption, $kol);	
	
	$otdel = strstr($caption, 10, true);
	$kol=strlen($otdel)+1;			
	$caption = substr($caption, $kol);	
	
	$pos = strpos($otdel, '#');
	if ($pos === false) {
		$reply = "Лот №{$id} не подойдёт, он видимо ещё старого образца, без хештега.";
		if ($chat_type=='private'||$callbackChat_type=='private'){
			$tg->sendMessage($chat_id, $reply); 
		}else $tg->sendMessage($admin_group, $reply); 		
		exit('ok');
	}

	$caption2 = strstr($caption, 10, true);
	$kol=strlen($caption2)+1;			
	$caption = substr($caption, $kol);	
	
	if ($caption2=='') exit('ok');

	$caption3 = strstr($caption, 10, true);
	$kol=strlen($caption3)+1;			
	$caption = substr($caption, $kol);	
	
	if ($caption3=='') exit('ok');

	$pos = strpos($caption, 10);
	
	if ($pos === false) {
		$caption4 = $caption;
		$caption5 = null;
		$doverie = '0';
	} else {
	
		$caption4 = strstr($caption, 10, true);
		$kol=strlen($caption4)+1;			
		$caption = substr($caption, $kol);	
	
		//
		$pos = strpos($caption, 10);

		if ($pos === false) {
			$caption5 = $caption;
			$doverie = '0';
		} else {
			$caption5 = strstr($caption, 10, true);
			$kol=strlen($caption5)+1;			
			$caption = substr($caption, $kol);	
	
			$ishnee = strstr($caption, 10, true);	
			$kol=strlen($ishnee)+1;	
			$caption = substr($caption, $kol);	
	
			$doverie = $caption;
			if ($doverie == '') $doverie = '0';
		}
	
	}
	
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
		$flag_delete = '0';
		$query = "DELETE FROM ".$table5." WHERE id=". $id;			
		if ($result = $mysqli->query($query)) {	
			$flag_delete = '1';
		}else $tg->sendMessage($admin_group, "Не получается удалить дублирующий лот #".$id);	
		
	}		
	
	$query = "INSERT INTO ".$table5." VALUES ('{$id}', '{$otdel}', '{$format}', '{$file_id}', '{$urlCaption}'".
		", '{$caption1}', '{$caption2}', '{$caption3}', '{$caption4}', '{$caption5}', '{$doverie}'".
		", '{$urlPodrobno}', '{$time}')";	
	
	if ($result = $mysqli->query($query)) {		
		if ($flag_delete == '1') {
			$reply="Лот {$id} обновлён и добавлен в категорию ".$otdel;
		}else $reply="Новый лот {$id} добавлен в категорию ".$otdel;
		if ( ($chat_type=='private'||$callbackChat_type=='private') ){				
			$tg->sendMessage($chat_id, $reply); 
		}else $tg->sendMessage($admin_group, $reply); 
		//exit('ok');
	}else{ 
		$reply="Не получилось добавить лот {$id} в категорию ".$otdel;
		if ( ($chat_type=='private'||$callbackChat_type=='private') ){		
			$tg->sendMessage($chat_id, $reply); 
		}else $tg->sendMessage($admin_group, $reply); 		
	}
	

	//-------------------------------------------------------------------
	//проверяю есть ли в базе лоты которые там месяц лежат без обновления	
	$month = '2629743';	
	$timeMinusMonth = $time - $month;  

	$query = "SELECT id, format, time FROM ".$table5." WHERE time<".$timeMinusMonth;
	if ($result = $mysqli->query($query)) {		
		$kol = $result->num_rows;
		if($kol>0){
	
			$arrayResult = $result->fetch_all(MYSQLI_ASSOC);
			$schetchik = 0;
			foreach($arrayResult as $stroka){
			
				if ($stroka['format']=='video'){
					$key = $stroka['id'] . ".mp4";
				}elseif ($stroka['format']=='photo'){
					$key = $stroka['id'] . ".jpg";
				}					
				
				$result = $s3->deleteObjects([
					'Bucket' => $aws_bucket,			
					'Delete' => [
						'Objects' => [
							[
								'Key' => $key,						
							],            
						],				
					],
				]);
				
				if ($result['@metadata']['statusCode']=='200'){
					$schetchik++;					
				}else $tg->sendMessage($master, "Чего то не получается удалить лот {$stroka['id']} из Amazon");	
		
			}
			
			if ($schetchik>'0'){
				$reply = "Произвёл удаление старых лотов из Amazon!";
				if ( ($chat_type=='private'||$callbackChat_type=='private') ){	
					$tg->sendMessage($chat_id, $reply);	
				}else $tg->sendMessage($admin_group, $reply);	
			}
		
			$query = "DELETE FROM ".$table5." WHERE time<".$timeMinusMonth;				
			if ($result = $mysqli->query($query)) {	
				$reply = "Совершенно удаление старых лотов из БД!";
				if ( ($chat_type=='private'||$callbackChat_type=='private') ){	
					$tg->sendMessage($chat_id, $reply);								
				}else $tg->sendMessage($admin_group, $reply);	
			}else {
				$reply = "Не получается удалить старые лоты из БД!";
				if ( ($chat_type=='private'||$callbackChat_type=='private') ){	
					$tg->sendMessage($chat_id, $reply);	
				}else $tg->sendMessage($admin_group, $reply);	
			}
			
		}
	}else throw new Exception("Не смог проверить таблицу ".$table5." на наличие старых лотов.");
	//------------------------------------------------------------------------------------------
	
	
}elseif ( ($chat_type=='private'||$callbackChat_type=='private') ){				
	$tg->sendMessage($chat_id, "Неее, мне надо с фоткой или с видео..\n..гифка не катит)"); 
}else $tg->sendMessage($admin_group, "Этот лот не по формату, надо или фото или видео."); 	







?>