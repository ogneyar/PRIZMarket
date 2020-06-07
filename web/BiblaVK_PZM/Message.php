<?

if ($text == "Прива") {	
	$random_id = time();	
	$массив = [
		"access_token" => $vk_token, 
		"random_id" => $random_id, 
		"peer_id" => $peer_id, 
		"message" => "Ну да, здравствуй)", 
		"v" => $vk_api_version
	];
	file_get_contents("https://api.vk.com/method/". "messages.send?". http_build_query($массив));

}elseif ($text=='курс' || $text=='Курс') {
    $курс = _kurs_PZM();
    $курс = str_replace("[CoinMarketCap](https://coinmarketcap.com/ru/currencies/prizm/)", "CoinMarketCap.com", $курс);
	$vk->messagesSend($peer_id, $курс);

}elseif ($text == "закрепи" || $text == "Закрепи") {	
	
	$текст = "Текст для закрепа";	
	$message_id = $vk->messagesSend($peer_id, $текст);
	
	$результат = $vk->messagesPin($peer_id, $message_id);
	//$результJSON = json_encode($результат);
	//$vk->messagesSend($peer_id, $результJSON);
	
	
}elseif ($text == "открепи" || $text == "Открепи") {	
	
	$текст = "Текст для закрепа";	
	$message_id = $vk->messagesSend($peer_id, $текст);
	
	$результат = $vk->messagesPin($peer_id, $message_id);
	//$результJSON = json_encode($результат);
	//$vk->messagesSend($peer_id, $результJSON);
	
	
}elseif ($text == "измени" || $text == "Измени") {	
	
	$текст = "А";
	$vk->messagesSend($peer_id, $текст);
	sleep(1);
	$message_id = $vk->messagesSend($peer_id, $текст);
	sleep(1);
	$vk->messagesSend($peer_id, $текст);
	sleep(1);
		
	$результат = $vk->messagesEdit($peer_id, $message_id, "Зачем?");
		
	
}elseif ($text == "загрузи") {		
	$результат = $vk2->photosGetUploadServer($vk_album_id, $vk_group_id);	
	if ($результат['error_msg']) {		
		$vk->messagesSend($peer_id, "Ошибка: ".$результат['error_msg']);
		exit;		
	}	
	$vk->messagesSend($peer_id, "upload_url: ".$результат['upload_url']);	
	//$bot->sendMessage($master, "upload_url: ".$результат['upload_url']);		
	$результат = $vk2->upload($результат['upload_url'], "http://f0430377.xsph.ru/image/test5eccceaecbdc4.jpg");	
	$server = $результат['server'];
	$photos_list = $результат['photos_list'];
	$hash = $результат['hash'];	
	if ($photos_list == []) {		
		$vk->messagesSend($peer_id, "Ошибка: photos_list пуст");
		exit;		
	}		
	$vk->messagesSend($peer_id, "server: {$server}, photos_list: {$photos_list}, hash: {$hash}");		
	$результат = $vk2->photosSave($vk_album_id, $vk_group_id, $server, $photos_list, $hash);		
	if ($результат['error_msg']) {		
		$vk->messagesSend($peer_id, "Ошибка: ".$результат['error_msg']);
		exit;		
	}	
	//https://vk.com/photo-190150616_457239042
	$ссылка_на_фото_в_вк = "https://vk.com/photo".$результат[0]['owner_id']."_".$результат[0]['id'];
	$vk->messagesSend($peer_id, $ссылка_на_фото_в_вк);	
	foreach($результат[0]['sizes'] as $size) {		
		$ссылка_на_фото = $size['url'];			
	}		
	//https://sun9-52.userapi.com/c857324/v857324167/19ed96/BiXlvgG5oNw.jpg
	$vk->messagesSend($peer_id, $ссылка_на_фото);
	
}elseif ($text == "Пост") {	
	$vk2->wallPost(-$vk_group_id, "#куплю\n\n#еду за PRIZM\n\n#дорого", "photo-188536519_457239037");	 
	$vk->messagesSend($peer_id, "Отправил");
}

/*else {
    $vk->messagesSend($peer_id, "не пойму(");
}*/


?>