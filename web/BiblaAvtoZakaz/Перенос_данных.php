<?

foreach ($caption_entities as $ent) {
		
	if ($ent['type']=='text_link') $urlCaption=$ent['url'];
	
}

if ($photo||$video){
		
	$url_podrobnee = $reply_markup['inline_keyboard'][0][0]['url'];	
		
	$id = substr(strrchr($url_podrobnee, '/'), 1);	
	
	if (_есть_ли_лот($id)) {		
		$bot->sendMessage($chat_id, "Такой лот ({$id}) уже есть!"); 	
		exit('ok');
	}		
		
	$time = time()-80000;
	$doverie = 0;
		
	$caption = str_replace("'", "\'", $caption);

	$kuplu_prodam = strstr($caption, 10, true);
	$kol=strlen($kuplu_prodam)+1;			
	$caption = substr($caption, $kol);	
		
	if ($kuplu_prodam=='') exit('ok');
		
	$лишняя_строка = strstr($caption, 10, true);	
	$kol=strlen($лишняя_строка)+1;	
	$caption = substr($caption, $kol);	
		
	$otdel = strstr($caption, 10, true);
	$kol=strlen($otdel)+1;			
	$caption = substr($caption, $kol);	
		
	$pos = strpos($otdel, '#');
	if ($pos === false) {
		$reply = "Лот №{$id} не подойдёт, он видимо ещё старого образца, без хештега.";
		$bot->sendMessage($chat_id, $reply); 
		exit('ok');
	}

	$nazvanie = strstr($caption, 10, true);
	$kol=strlen($nazvanie)+1;			
	$caption = substr($caption, $kol);	
		
	if ($nazvanie=='') exit('ok');
	$nazvanie = str_replace("▪️", "", $nazvanie);

	$valuta = strstr($caption, 10, true);
	$kol=strlen($valuta)+1;			
	$caption = substr($caption, $kol);	
		
	if ($valuta=='') exit('ok');
	$valuta = str_replace("▪️", "", $valuta);
		
	$gorod = strstr($caption, 10, true);
	$kol=strlen($gorod)+1;			
	$caption = substr($caption, $kol);	
		
	if ($gorod=='') exit('ok');
	$gorod = str_replace("▪️", "", $gorod);	
		
	$pos = strpos($caption, 10);
		
	if ($pos === false) {
		$username = $caption;			
	}else {	
		$username = strstr($caption, 10, true);
		$kol=strlen($username)+1;			
		$caption = substr($caption, $kol);		
			
		$pos = strpos($caption, 10);
		
		if ($pos === false) {				
			$doverie = 0;
		} else {					
			$doverie = 1;	
		}		
			
	}	
	//$username = str_replace("▪️", "", $username);	
	$username = strrchr($username, "@");
	
	$id_client = _дай_айди($username);
	
	$Объект_файла = $bot->getFile($file_id);		
	$ссыль_на_файл = $bot->fileUrl . $bot->token;			
	$ссыль = $ссыль_на_файл . "/" . $Объект_файла['file_path'];							
	$результат = $imgBB->upload($ссыль);										
	if ($результат) {								
		$url_tgraph = $результат['url'];						
	}else $bot->sendMessage($chat_id, "Не смог сделать редакт url_tgraph");		
		
	$query = "INSERT INTO {$table_market} VALUES (
		'{$id_client}', '{$id}', '{$kuplu_prodam}', '{$nazvanie}', '{$urlCaption}',
		'{$valuta}', '{$gorod}', '{$username}', '{$doverie}', '{$otdel}', '{$формат_файла}',
		'{$file_id}', '{$url_podrobnee}', 'перенесён', '', '{$url_tgraph}', '', '', '{$time}'
	)";	
	
	$result = $mysqli->query($query);
	
	if ($result) {				
		$bot->sendMessage($chat_id, "Лот {$id} добавлен в базу."); 				
	}else{ 		
		$bot->sendMessage($chat_id, "Не получилось добавить лот {$id}"); 		
	}

}else {				
	$bot->sendMessage($chat_id, "Неее, мне надо с фоткой или с видео.."); 
}



?>