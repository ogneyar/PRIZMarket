<?php

//ОСНОВНАЯ РАБОТА БОТА, ВЫПОЛНЕНИЕ КОМАНД (РЕАКЦИЯ НА РЕПЛИКИ ПОЛЬЗОВАТЕЛЯ)

if (strpos($text, "/start ")!==false) $nomerZayavki = str_replace ("/start ", "", $text);
if ($nomerZayavki) {
	$text = "ПоявилсяПокупатель";
	$id_message_chat =  strstr($nomerZayavki, '-', true);
	$id_zakaza =  substr(strrchr($nomerZayavki, '-'), 1);
}


if ($text == "Курс чата"||$text == "курс чата") {  // Курс PRIZM
			
	$reply = _kurs_PZM();
	
	// КНОПКА Репост
	$inLine10_but1=["text"=>"Репост","switch_inline_query"=>"курс"];
	$inLine10_str1=[$inLine10_but1];
	$inLine10_keyb=[$inLine10_str1];
	$keyInLine10 = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLine10_keyb);
	
	$tg->call('sendMessage', [
        'chat_id' => $chat_id,
        'text' => $reply,
        'parse_mode' => markdown,
        'disable_web_page_preview' => true,
        'reply_to_message_id' => null,
        'reply_markup' => $keyInLine10->toJson(),
        'disable_notification' => false,
    ]);
			
			
}elseif ($text == "Настройки") {  //Подсказка для Гарантов как Настроить бота


	$reply = "Эта информация для Гарантов, администраторов P2P-обменников:\n\n".
		"Для начала работы с ботом *Безопасные Сделки* требуется выполнить".
		" \x32\xE2\x83\xA3 действия.\n   \xE2\x9D\x97 ВАЖНО \xE2\x9D\x97\n".
		"сохранить последовательность добавления БОТа в ЧАТы \xE2\x9D\x97\n\n".
		"  \x31\xE2\x83\xA3 добавьте меня (бота - @order\_a\_deal\_bot) в чат".
		" P2P-обменник и сделайте меня (бота) администратором чата.\n\n".
		"  \x32\xE2\x83\xA3 создайте чат(группу) АДМИНИСТРИРОВАНИЯ.\n\n\n".
		"     \xE2\x9D\x97 \xE2\x9D\x97 ВНИМАНИЕ \xE2\x9D\x97 \xE2\x9D\x97 \n".		
		"в группе администрирования должны находиться только ГАРАНТЫ и они".		
		" должны быть администраторами чата, так же в Чате(группе) сделайте ".
		"меня (бота) администратором.\n\n{$tehPodderjka}";
	$tg->sendMessage($chat_id, $reply, markdown);			


	
			
}elseif ($text == "ПоявилсяПокупатель") {  
	
	_est_li_v_base();
	
	$est_li_v_gruppe = _proverka_zakaza($id_zakaza);
	
	if ($est_li_v_gruppe) {					
			
		$query = "SELECT * FROM ". $table4 . " WHERE id_zakaz=".$id_zakaza; 
		if ($result = $mysqli->query($query)) {					
			if($result->num_rows>0){
				$strZakaz = $result->fetch_all(MYSQLI_ASSOC);			
			}else exit('ok');
		}else exit('ok');
		
		$reply = "Появился потенциальный покупатель!\n".
			"@".$user_name."\nна эту заявку \xF0\x9F\x91\x87\n\n".		
			"\xF0\x9F\x97\xA3 #".$strZakaz[0]['vibor']."\n".
			"\xF0\x9F\x92\xB0 " .$strZakaz[0]['kol_monet']. " ".$strZakaz[0]['monet']."\n".
			"\xF0\x9F\x92\xB8 ".$strZakaz[0]['cena']." ".$strZakaz[0]['valuta'].
				" (".$strZakaz[0]['itog'].")\n".
			"\xF0\x9F\x8F\xA6 ".$strZakaz[0]['bank']."\n".
			"\xF0\x9F\x91\xA4 ".$strZakaz[0]['client_username']."\n\n".
			$from_id.":".$nomerZayavki.".".$strZakaz[0]['id_client'];	
			
		$inLineKey_menu = [[["text"=>"Принять заявку","callback_data"=>"prinyal_zayavku_admin"]]];
		$keyInLine = new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($inLineKey_menu);
			
		$tg->sendMessage($est_li_v_gruppe, $reply, null, true, null, $keyInLine);
			
			
		$MenuStart	= [["Старт", "Настройки"]];	
		$keyboardStartNastr = new \TelegramBot\Api\Types\ReplyKeyboardMarkup($MenuStart, false, true);  	
			
		$tg->sendMessage($chat_id, "Ожидайте..", null, true, null, $keyboardStartNastr);
			
	}

	
	
}elseif ($text!=="/start"&&$text!=="s"&&$text!=="S"&&$text!=="с"&&$text!=="С"&&$text!=="c"&&$text!=="C"&&$text !== "Старт"&&$text !== "старт") {

	if (($this_admin==true)||($from_id==$master)) {
		include_once '10_admin.php';
	}else{
		if ($chat_type=='private'||$callbackChat_type=='private') { 
			$reply = "Я не пойму эту команду. \xF0\x9F\x98\xB3\nВозможно из-за ОБНОВЛЕНИЯ меня ".
				"(бота) произошло недопонимание. \n" . $first_name . ", попробуйте нажать /start";
		
			$tg->sendMessage($chat_id, $reply);		
		}
		
	}
}


if (($text)&&($this_admin==false)&&($chat_id!==$master)){

	//ОТПРАВКА ИФОРМАЦИИ О СООБЩЕНИИ В ГРУППУ 

	$reply = $first_name . " (@{$user_name}) пишет:\n" . $text . "\n". $chat_id . ":" . $message_id . " r.";
	
	$tg->call('sendMessage', [
            'chat_id' => $admin_group,
            'text' => $reply,
            'parse_mode' => null,
            'disable_web_page_preview' => true,
            'reply_to_message_id' => null,
            'reply_markup' => null,
            'disable_notification' => false,
    ]);
	
}




	
?>