<?
$text = str_replace("[club190150616|@pzmarket] ", "", $text);
$text = str_replace("[club190150616|TesterPRIZMarket] ", "", $text);
$text = str_replace("[club188536519|@prizmarket_vk] ", "", $text);
$text = str_replace("[club188536519|Покупки на PRIZMarket] ", "", $text);

$это_ссылка = $vk2->wallCheckCopyrightLink($text);

if (!$это_ссылка['error_code']) {
	$vk->messagesSend($peer_id, "Здесь ссылки запрещены!");
	echo "Ошибка!";
	exit;
}

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

}elseif (($text == "тест" || $text == "Тест")&&($tester == 'да')) {	
	
	$action1 = [ 'type' => 'text', 'label' => 'Прива', 'payload' => [ 
		'button' => '1' ] ];
	$action2 = [ 'type' => 'text', 'label' => 'Закрепи', 'payload' => [ 
		'button' => '2' ] ];
	$action3 = [ 'type' => 'text', 'label' => 'Открепи', 'payload' => [ 
		'button' => '3' ] ];
	$action4 = [ 'type' => 'text', 'label' => 'Измени', 'payload' => [ 
		'button' => '4' ] ];
	$action5 = [ 'type' => 'text', 'label' => 'Удали', 'payload' => [ 
		'button' => '5' ] ];
	$action6 = [ 'type' => 'text', 'label' => 'Н.Беседа', 'payload' => [ 
		'button' => '6' ] ];
	$action7 = [ 'type' => 'text', 'label' => 'Пост', 'payload' => [ 
		'button' => '7' ] ];
	$action8 = [ 'type' => 'text', 'label' => 'УдалиПост', 'payload' => [ 
		'button' => '8' ] ];
	$action9 = [ 'type' => 'text', 'label' => 'ИзмениПост', 'payload' => [ 
		'button' => '9' ] ];
	$action10 = [ 'type' => 'text', 'label' => 'КоментПоста', 'payload' => [ 
		'button' => '10' ] ];
	$action11 = [ 'type' => 'text', 'label' => 'УдалиКомент', 'payload' => [ 
		'button' => '11' ] ];
	$action12 = [ 'type' => 'text', 'label' => 'ИзмениКомент', 'payload' => [ 
		'button' => '12' ] ];
	$action13 = [ 'type' => 'text', 'label' => 'СписокПостов', 'payload' => [ 
		'button' => '13' ] ];
	$action14 = [ 'type' => 'text', 'label' => 'НомерПоста', 'payload' => [ 
		'button' => '14' ] ];
	$action15 = [ 'type' => 'text', 'label' => 'ПоискПоста', 'payload' => [ 
		'button' => '15' ] ];
	$action16 = [ 'type' => 'text', 'label' => 'НомерКоммента', 'payload' => [ 
		'button' => '16' ] ];
	$action17 = [ 'type' => 'text', 'label' => 'ВсеКомменты', 'payload' => [ 
		'button' => '17' ] ];
	$action18 = [ 'type' => 'text', 'label' => 'ДайРепосты', 'payload' => [ 
		'button' => '18' ] ];
	$action19 = [ 'type' => 'text', 'label' => 'ЗапретКоммента', 'payload' => [ 
		'button' => '19' ] ];
	$action20 = [ 'type' => 'text', 'label' => 'МожноКомментить', 'payload' => [ 
		'button' => '20' ] ];
	$action21 = [ 'type' => 'text', 'label' => 'Пусто', 'payload' => [ 
		'button' => '21' ] ];
	$action22 = [ 'type' => 'text', 'label' => 'ЗакрепПоста', 'payload' => [ 
		'button' => '22' ] ];
	$action23 = [ 'type' => 'text', 'label' => 'ОткрепПоста', 'payload' => [ 
		'button' => '23' ] ];
	$action24 = [ 'type' => 'text', 'label' => 'Пусто', 'payload' => [ 
		'button' => '24' ] ];
	$кнопки = [
	[	[ 	'action' => $action1, 'color' => 'secondary' ],
		[	'action' => $action2, 'color' => 'positive' ],
		[	'action' => $action3, 'color' => 'negative' ]
	],[	[	'action' => $action4, 'color' => 'primary' ],
		[	'action' => $action5, 'color' => 'secondary' ],
		[	'action' => $action6, 'color' => 'positive' ]
	],[	[	'action' => $action7, 'color' => 'negative' ],
		[	'action' => $action8, 'color' => 'primary' ],
		[	'action' => $action9, 'color' => 'secondary' ]
	],[	[	'action' => $action10, 'color' => 'positive' ],
		[	'action' => $action11, 'color' => 'negative' ],
		[	'action' => $action12, 'color' => 'primary' ]
	],[	[	'action' => $action13, 'color' => 'secondary' ],
		[	'action' => $action14, 'color' => 'positive' ],
		[	'action' => $action15, 'color' => 'negative' ]
	],[	[	'action' => $action16, 'color' => 'primary' ],
		[	'action' => $action17, 'color' => 'secondary' ],
		[	'action' => $action18, 'color' => 'positive' ]
	],[	[	'action' => $action19, 'color' => 'negative' ],
		[	'action' => $action20, 'color' => 'primary' ],
		[	'action' => $action21, 'color' => 'secondary' ]
	],[	[	'action' => $action22, 'color' => 'positive' ],
		[	'action' => $action23, 'color' => 'negative' ],
		[	'action' => $action24, 'color' => 'primary' ]
	] ];
	$клавиатура_в_сообщении = [
		'one_time' => false,
		'buttons' => $кнопки,
		'inline' => false
	];	
	$клавиатура = json_encode($клавиатура_в_сообщении);	
	$результат = $vk->messagesSend($peer_id, "Нажми на кнопку!", null, null, null, $клавиатура);
	
	
}elseif ($text == "убериКлаву") {	
	
	$убрать_клавиатуру = [
		'one_time' => false,
		'buttons' => [],
		'inline' => false
	];	
	$клавиатура = json_encode($убрать_клавиатуру);
	
	$message_id = $vk->messagesSend($peer_id, "Убрал", null, null, null, $клавиатура);
	
	
}elseif ($text == "закрепи" || $text == "Закрепи") {	
	
	$текст = "Текст для закрепа";	
	$message_id = $vk->messagesSend($peer_id, $текст);
	
	$результат = $vk->messagesPin($peer_id, $message_id);
	
	
}elseif ($text == "открепи" || $text == "Открепи") {	
	
	$vk->messagesUnpin($peer_id, $group_id);
	
	
}elseif ($text == "измени" || $text == "Измени") {	
	
	$текст = "А";
	$vk->messagesSend($peer_id, $текст);
	sleep(1);
	$message_id = $vk->messagesSend($peer_id, $текст);
	sleep(1);
		
	$результат = $vk->messagesEdit($peer_id, $message_id, "Зачем?");
	
	
}elseif ($text == "удали" || $text == "Удали") {	
		
	$vk->messagesSend($peer_id, "А");
	sleep(1);
	$message_id = $vk->messagesSend($peer_id, "Б");
	sleep(1);
	$vk->messagesSend($peer_id, "А");
	sleep(1);
	
	$результат = $vk->messagesDelete([$message_id], $group_id, true);
	
	
}elseif ($text == "Н.Беседа") {	
		
	$результат = $vk->messagesCreateChat([119909267], "Автоматически созданная беседа", $group_id);
	$результJSON = json_encode($результат);
	$vk->messagesSend($peer_id, $результJSON);
	
	
}elseif ($text == "Пост") {	
	$результат = $vk2->wallPost(-$vk_group_id, "Тестовый текст");	 
	$vk->messagesSend($peer_id, "Опубликовал пост.");
	
	
}elseif ($text == "УдалиПост") {	
	$результат = $vk2->wallPost(-$vk_group_id, "Тестовый текст");	 
	$vk->messagesSend($peer_id, "Опубликовал, смотри. Через три секунды удалится пост!");
	sleep(3);
	$результат = $vk2->wallDelete(-$vk_group_id, $результат['post_id']);	 
	
	if ($результат) $vk->messagesSend($peer_id, "Удалил.");
	
}elseif ($text == "ИзмениПост") {	

	$результат = $vk2->wallPost(-$vk_group_id, "Тестовый текст для редактирования!");	 
	$vk->messagesSend($peer_id, "Опубликовал, смотри. Через три секунды изменится пост!");
	sleep(3);
	$результат = $vk2->wallEdit(-$vk_group_id, $результат['post_id'], "А теперь тут этот текст!");	 
	
	if ($результат) $vk->messagesSend($peer_id, "Изменил.");
	
	
}elseif ($text == "КоментПоста") {	

	$результат = $vk2->wallPost(-$vk_group_id, "Тестовый пост для коментирования!");	 
	$vk->messagesSend($peer_id, "Опубликовал, смотри. Через три секунды добавится комментарий!");
	sleep(3);
	$результат = $vk2->wallCreateComment(-$vk_group_id, $результат['post_id'], "Вот такой тут коммент!");	 
	
	if ($результат['comment_id']) $vk->messagesSend($peer_id, "Добавил комментарий.");
	
	
}elseif ($text == "УдалиКомент") {	

	$результат = $vk2->wallPost(-$vk_group_id, "Тестовый пост для удаления комментария!");	 
	$результат = $vk2->wallCreateComment(-$vk_group_id, $результат['post_id'], "Комментарий для удаления!");	
	$vk->messagesSend($peer_id, "Опубликовал, смотри. Через три секунды удалится комментарий!");
	sleep(3);
	$результат = $vk2->wallDeleteComment(-$vk_group_id, $результат['comment_id']);	 
	
	if ($результат) $vk->messagesSend($peer_id, "Удалил комментарий.");
	
	
}elseif ($text == "ИзмениКомент") {	
	
	$результат = $vk2->wallPost(-$vk_group_id, "Тестовый пост для редактирования комментария!");	 
	$результат = $vk2->wallCreateComment(-$vk_group_id, $результат['post_id'], "Комментарий для редактирования!");	
	$vk->messagesSend($peer_id, "Опубликовал, смотри. Через три секунды изменится комментарий!");
	sleep(3);
	$результат = $vk2->wallEditComment(-$vk_group_id, $результат['comment_id'], "Вот такой теперь тут коммент.");	 
	
	if ($результат) $vk->messagesSend($peer_id, "Изменил комментарий.");
	
	
}elseif ($text == "СписокПостов") {	
	
	$результат = $vk2->wallGet(-$vk_group_id, null, null, 1);
	$результJSON = json_encode($результат);
	$vk->messagesSend($peer_id, "Метод wall.get\n\n".$результJSON);
	
	
}elseif ($text == "НомерПоста") {	
	
	$результат = $vk2->wallPost(-$vk_group_id, "Тестовый пост! (wall.getById)");	 
	$vk->messagesSend($peer_id, "Опубликовал пост для метода wall.getById. Его номер: ".$результат['post_id']);
	
	$результат = $vk2->wallGetById(-$vk_group_id."_".$результат['post_id']);
	$результJSON = json_encode($результат);
	$vk->messagesSend($peer_id, $результJSON); // "Метод wall.getById\n\n".
	
	
}elseif ($text == "ПоискПоста") {	
		
	$vk->messagesSend($peer_id, "Поиск поста по слову: Закрепи");
		
	$результат = $vk2->wallSearch(-$vk_group_id, null, "Закрепи");
	$результJSON = json_encode($результат);
	$vk->messagesSend($peer_id, "Метод wall.search\n\n".$результJSON);
	
	
}elseif ($text == "НомерКоммента") {	
		
	$результат = $vk2->wallPost(-$vk_group_id, "Тестовый пост для wall.getComment!");	 
	$номер_поста = $результат['post_id'];
	$результат = $vk2->wallCreateComment(-$vk_group_id, $номер_поста, "Вот такой тут коммент для wall.getComment!");	
	$номер_коммента = $результат['comment_id'];
	$vk->messagesSend($peer_id, "Опубликовал пост и добавил комментарий. Номер коммента: {$номер_коммента}");
	
	$результат = $vk2->wallGetComment(-$vk_group_id, $номер_коммента);
	$результJSON = json_encode($результат);
	$vk->messagesSend($peer_id, "Метод wall.getComment\n\n".$результJSON);
	
	
}elseif ($text == "ВсеКомменты") {	
		
	$результат = $vk2->wallPost(-$vk_group_id, "Тестовый пост для wall.getComments! (s - на конце)");	 
	$номер_поста = $результат['post_id'];
	$результат = $vk2->wallCreateComment(-$vk_group_id, $номер_поста, "Вот такой тут коммент для wall.getComments! (s - на конце)");	
	$номер_коммента = $результат['comment_id'];
	$vk->messagesSend($peer_id, "Опубликовал пост и добавил комментарий. Номер поста: {$номер_поста}");
	
	$результат = $vk2->wallGetComments(-$vk_group_id, $номер_поста);
	$результJSON = json_encode($результат);
	$vk->messagesSend($peer_id, "Метод wall.getComments (s - на конце)\n\n".$результJSON);
	
	
}elseif ($text == "ДайРепосты") {	
	
	$номер_поста = 70;
	
	$vk->messagesSend($peer_id, "Инфа о репостах записи номер: {$номер_поста}!");
	
	$результат = $vk2->wallGetReposts(-$vk_group_id, $номер_поста);
	$результJSON = json_encode($результат);
	$vk->messagesSend($peer_id, "Метод wall.getReposts\n\n".$результJSON);
	
	
}elseif ($text == "ЗапретКоммента") {	
		
	$результат = $vk2->wallPost(-$vk_group_id, "Тестовый пост для wall.closeComments!");	 
	$номер_поста = $результат['post_id'];
	$vk->messagesSend($peer_id, "Опубликовал пост для метода wall.closeComments. Номер поста: {$номер_поста}.");
	$результат = $vk2->wallCloseComments(-$vk_group_id, $номер_поста);
	if ($результат) $vk->messagesSend($peer_id, "Запретил его комментировать!");
	
	
}elseif ($text == "МожноКомментить") {	
		
	$результат = $vk2->wallPost(-$vk_group_id, "Тестовый пост для wall.openComments!");	 
	$номер_поста = $результат['post_id'];
	$vk->messagesSend($peer_id, "Опубликовал пост для метода wall.openComments. Номер поста: {$номер_поста}.");
	$результат = $vk2->wallCloseComments(-$vk_group_id, $номер_поста);
	if ($результат) $vk->messagesSend($peer_id, "Запретил его комментировать! Через 5 секуд разрешу комментировать его!");
	sleep(5);
	$результат = $vk2->wallOpenComments(-$vk_group_id, $номер_поста);
	if ($результат) $vk->messagesSend($peer_id, "Всё, разрешил!");
	
	
}elseif ($text == "ЗакрепПоста") {	
		
	$результат = $vk2->wallPost(-$vk_group_id, "Тестовый пост для wall.pin!");	 
	$номер_поста = $результат['post_id'];
	$vk->messagesSend($peer_id, "Опубликовал пост для метода wall.pin. Номер поста: {$номер_поста}.");
	
	$результат = $vk2->wallPin(-$vk_group_id, $номер_поста);
	if ($результат) $vk->messagesSend($peer_id, "Закрепил пост!");
	
}elseif ($text == "ОткрепПоста") {	
		
	$результат = $vk2->wallPost(-$vk_group_id, "Тестовый пост для wall.unpin!");	 
	$номер_поста = $результат['post_id'];
	$vk->messagesSend($peer_id, "Опубликовал пост для метода wall.unpin. Номер поста: {$номер_поста}.");
	
	$результат = $vk2->wallPin(-$vk_group_id, $номер_поста);
	if ($результат) $vk->messagesSend($peer_id, "Закрепил пост! Через 5 секунд его откреплю!");
	sleep(5);
	
	$результат = $vk2->wallUnpin(-$vk_group_id, $номер_поста);
	if ($результат) $vk->messagesSend($peer_id, "Открепил пост!");
	
	
}elseif ($text == "Пусто") {	
		
	$vk->messagesSend($peer_id, "Да, ещё пока тут пусто!");
	
	
}elseif ($text == "Пост") {	

	$vk2->wallPost(-$vk_group_id, "#куплю\n\n#еду за PRIZM\n\n#дорого", "photo-188536519_457239037");	 
	$vk->messagesSend($peer_id, "Отправил");
	
	
	
	
	
	
	
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
	
}elseif ($text == "еее" || $text == "Еее" || $text == "eee" || $text == "Eee" || $text == "ееее" || $text == "Ееее" || $text == "eeee" || $text == "Eeee") {	
	
	$текст = "Так держать, Мастер!";	
	$message_id = $vk->messagesSend($peer_id, $текст);
	
	
}

/*else {
    $vk->messagesSend($peer_id, "не пойму(");
}*/


?>
